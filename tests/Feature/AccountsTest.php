<?php

namespace Tests\Feature;

use App\User;
use App\Account;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function an_account_can_be_created()
    {
        // Disable the default exception handling
        $this->withoutExceptionHandling();

        // Act as a user
        $this->actAsUser();

        // Try to create an account trough route
        $response = $this->post(route('accounts.consultants.store'), [
            'uuid' => $this->faker->uuid(),
            'firstname' => $this->faker->firstNameFemale(),
            'lastname' => $this->faker->lastName(9),
            'title' => $this->faker->jobTitle(),
            'mobile' => '0701234567',
            'vht' => '12345',
            'ansvar' => '12345',
            'company' => 'Soltak AB',
            'consultantCompany' => $this->faker->company(),
            'department' => 'IT',
            'managerUuid' => $this->faker->uuid(),
            'employeeType' => 'Consultant',
            'startDate' => $this->faker->iso8601(),
            'endDate' => $this->faker->iso8601('+1 year'),
            'localAccount' => 0,
            'isEdu' => 0,
            'createdBy' => 1
        ]);

        // Check if response was redirected to the created user
        $response->assertRedirect(Account::first()->path());

        // Check if account was added to database
        $this->assertCount(1, Account::all());
    }

    /** @test */
    public function an_account_can_be_updated()
    {
        // Disable the default exception handling
        $this->withoutExceptionHandling();

        // Act as a user
        $this->actAsUser();

        // Create account
        $this->createAccount();

        // Get the account from the database
        $account = Account::first();

        // Try to update the account through route
        $response = $this->patch(route('accounts.consultants.update', $account->id), [
            'firstname' => 'Jane'
        ]);

        // Check if the account was updated
        $this->assertEquals('Jane', $account->fresh()->firstname);

        // Check if the user was redirected
        $response->assertRedirect(Account::first()->path());
    }

    /** @test */
    public function an_account_can_be_deleted()
    {
        // Disable the default exception handling
        $this->withoutExceptionHandling();

        // Act as a user
        $this->actAsUser();

        // Create account
        $this->createAccount();

        // Check if the account exists in the database
        $this->assertCount(1, Account::all());

        // Get the account from the database
        $account = Account::first();

        // Try to delete the account through route
        $response = $this->delete(route('accounts.consultants.delete', $account->id));

        // Check of the account was deleted
        $this->assertCount(0, Account::all());

        // Check of the user was redirected
        $response->assertRedirect(route('accounts.index'));
    }




    /* # Helpers # */
    protected function createAccount()
    {
        return  $this->post(route('accounts.consultants.store'), [
            'uuid' => $this->faker->uuid(),
            'firstname' => $this->faker->firstNameFemale(),
            'lastname' => $this->faker->lastName(9),
            'title' => $this->faker->jobTitle(),
            'mobile' => '0701234567',
            'vht' => '12345',
            'ansvar' => '12345',
            'company' => 'Soltak AB',
            'consultantCompany' => $this->faker->company(),
            'department' => 'IT',
            'managerUuid' => $this->faker->uuid(),
            'employeeType' => 'Consultant',
            'startDate' => $this->faker->iso8601(),
            'endDate' => $this->faker->iso8601('+1 year'),
            'localAccount' => 0,
            'isEdu' => 0,
            'createdBy' => 1
        ]);
    }

    protected function actAsUser()
    {
        // Create a user
        factory(User::class, 1)->create();

        // Act as the user
        return $this->actingAs(User::first());
    }

}
