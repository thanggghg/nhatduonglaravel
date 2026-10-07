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
}
