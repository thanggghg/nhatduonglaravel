<?php

namespace Tests\Unit;

use App\Http\Controllers\Admin\AdminPostController;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class AdminPostContentSanitizerTest extends TestCase
{
    #[Test]
    public function it_preserves_utf8_content_and_safe_font_formatting(): void
    {
        $method = new ReflectionMethod(AdminPostController::class, 'sanitizeContent');
        $method->setAccessible(true);

        $html = $method->invoke(
            new AdminPostController(),
            '<p>Tiếng Việt: Trường, đường, Nguyễn</p><font face="Georgia" size="4">Nội dung</font>'
        );

        $this->assertStringContainsString('Tiếng Việt: Trường, đường, Nguyễn', $html);
        $this->assertStringContainsString('<font face="Georgia" size="4">Nội dung</font>', $html);
    }

    #[Test]
    public function it_removes_unsafe_font_values(): void
    {
        $method = new ReflectionMethod(AdminPostController::class, 'sanitizeContent');
        $method->setAccessible(true);

        $html = $method->invoke(
            new AdminPostController(),
            '<font face="Untrusted Font" size="99">Nội dung</font>'
        );

        $this->assertSame('<font>Nội dung</font>', $html);
    }

    #[Test]
    public function it_keeps_only_a_safe_responsive_image_width(): void
    {
        $method = new ReflectionMethod(AdminPostController::class, 'sanitizeContent');
        $method->setAccessible(true);

        $html = $method->invoke(
            new AdminPostController(),
            '<img src="/storage/posts/content/example.webp" alt="Ảnh" style="width: 55%; position: fixed">'
        );

        $this->assertStringContainsString('style="width: 55%;"', $html);
        $this->assertStringNotContainsString('position', $html);
    }

    #[Test]
    public function it_preserves_only_supported_gallery_layouts(): void
    {
        $method = new ReflectionMethod(AdminPostController::class, 'sanitizeContent');
        $method->setAccessible(true);

        $safe = $method->invoke(
            new AdminPostController(),
            '<div class="article-gallery article-gallery--trio-left"><figure><img src="/storage/posts/content/one.webp"></figure></div>'
        );
        $unsafe = $method->invoke(
            new AdminPostController(),
            '<div class="unknown-layout"><img src="/storage/posts/content/one.webp"></div>'
        );

        $this->assertStringContainsString('class="article-gallery article-gallery--trio-left"', $safe);
        $this->assertStringNotContainsString('unknown-layout', $unsafe);
    }
}
