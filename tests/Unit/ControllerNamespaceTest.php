<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ControllerNamespaceTest extends TestCase
{
    public function test_member_and_admin_dashboard_controllers_can_be_resolved(): void
    {
        $this->assertTrue(class_exists(\App\Http\Controllers\Member\DashboardController::class));
        $this->assertTrue(class_exists(\App\Http\Controllers\Admin\DashboardController::class));
    }
}
