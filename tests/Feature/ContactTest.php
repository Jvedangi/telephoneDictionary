<?php

namespace Tests\Feature;

use App\Models\ContactGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected ContactGroup $contactGroup;
    protected string $testCaseId;
    protected string $expectedResult;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->contactGroup = ContactGroup::factory()->create(['user_id' => $this->user->id]);
        $this->actingAs($this->user);
    }

    public function test_create_contact_with_valid_data(): void
    {
        $this->testCaseId = 'TC001';
        $this->expectedResult = 'Contact should be saved successfully and appear in the contact list.';

        $response = $this->post('/contacts', [
            'name' => 'John Doe',
            'phone_number' => '1234567890',
            'email' => 'john.doe@example.com',
            'group_id' => $this->contactGroup->id,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'phone_number' => '1234567890',
            'email' => 'john.doe@example.com',
        ]);
    }

    public function test_prevent_duplicate_phone_number(): void
    {
        $this->testCaseId = 'TC002';
        $this->expectedResult = 'System should show validation error "Phone number already exists".';

        $this->post('/contacts', [
            'name' => 'John Doe',
            'phone_number' => '1234567890',
            'email' => 'john.doe@example.com',
            'group_id' => $this->contactGroup->id,
        ]);

        $response = $this->post('/contacts', [
            'name' => 'Jane Doe',
            'phone_number' => '1234567890',
            'email' => 'jane.doe@example.com',
            'group_id' => $this->contactGroup->id,
        ]);

        $response->assertSessionHasErrors('phone_number');
    }

    public function test_validate_required_fields(): void
    {
        $this->testCaseId = 'TC003';
        $this->expectedResult = 'Validation message should appear for required fields.';

        $response = $this->post('/contacts', [
            'name' => '',
            'phone_number' => '',
            'email' => '',
            'group_id' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'phone_number', 'group_id']);
    }

    public function test_search_contact(): void
    {
        $this->testCaseId = 'TC004';
        $this->expectedResult = 'System should display matching contacts.';

        $this->post('/contacts', [
            'name' => 'John Doe',
            'phone_number' => '1234567890',
            'email' => 'john.doe@example.com',
            'group_id' => $this->contactGroup->id,
        ]);

        $response = $this->get('/contacts?search=John');

        $response->assertSee('John Doe');
    }

    public function test_update_contact(): void
    {
        $this->testCaseId = 'TC005';
        $this->expectedResult = 'Contact details should be updated successfully.';

        $contact = \App\Models\Contact::factory()->create(['user_id' => $this->user->id, 'group_id' => $this->contactGroup->id]);

        $response = $this->put("/contacts/{$contact->id}", [
            'name' => 'Jane Doe',
            'phone_number' => '0987654321',
            'email' => 'jane.doe@example.com',
            'group_id' => $this->contactGroup->id,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Jane Doe',
            'phone_number' => '0987654321',
            'email' => 'jane.doe@example.com',
        ]);
    }

    public function test_delete_contact(): void
    {
        $this->testCaseId = 'TC006';
        $this->expectedResult = 'Contact should be removed from the contact list.';

        $contact = \App\Models\Contact::factory()->create(['user_id' => $this->user->id, 'group_id' => $this->contactGroup->id]);

        $response = $this->delete("/contacts/{$contact->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }
}
