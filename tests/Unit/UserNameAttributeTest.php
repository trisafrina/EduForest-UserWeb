<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class UserNameAttributeTest extends \Tests\TestCase
{
    #[Test]
    public function it_exposes_full_name_as_name_attribute(): void
    {
        $user = new User([
            'full_name' => 'Aisyah Binti Ali',
            'email' => 'aisyah@example.com',
        ]);

        $this->assertSame('Aisyah Binti Ali', $user->name);
    }
}
