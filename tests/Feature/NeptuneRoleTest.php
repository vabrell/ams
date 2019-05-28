<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\NeptuneRole;
use App\NeptuneContract;
use Tests\Feature\NeptuneContractTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NeptuneRoleTest extends TestCase
{
    // Refresh the database with all tests
    use RefreshDatabase;

    /** @test */
    public function a_role_can_be_created()
    {
        // Disable default Laravel exception handling
        $this->withoutExceptionHandling();

        // Try create a role through route
        $response = $this->createRole();

        // Check if response is OK
        $response->assertOK();

        // Check if the role was created successfully
        $this->assertCount(1, NeptuneRole::all());
    }

    /** @test */
    public function a_role_name_is_required()
    {
        // Create a role
        $response = $this->createRole($name = '');

        // Check if session has error for name
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_role_can_be_updated()
    {
        // Disable default Laravel exception handling
        $this->withoutExceptionHandling();

        // Create a role
        $this->createRole();

        // Get the role
        $role = NeptuneRole::first();

        // Try to update the role through route
        $this->patch($role->path(), [
            'name' => 'Medarbetare ny'
        ]);

        // Check if the update was successful
        $this->assertEquals('Medarbetare ny', $role->fresh()->name);
    }

    /** @test */
    public function a_role_can_be_deleted()
    {
        // Disable default Laravel exception handling
        $this->withoutExceptionHandling();

        // Create a role
        $this->createRole();

        // Check if a role was created
        $this->assertCount(1, NeptuneRole::all());

        // Get the role
        $role = NeptuneRole::first();

        // Try to delete the role through route
        $this->delete($role->path());

        // Check if the role was removed
        $this->assertCount(0, NeptuneRole::all());
    }

    /** @test */
    public function a_role_has_many_neptune_contracts_relationship()
    {
        // Create two contracts
        factory(NeptuneContract::class, 2)->create();

        // Check of contracts was created
        $this->assertCount(2, NeptuneContract::all());

        // Get the role class
        $role = new NeptuneRole;

        // Check if the role has one-to-many relationship to contracts
        $this->assertInstanceOf(HasMany::class, $role->contracts());
    }






    protected function createRole($name = 'Medarbetare')
    {
        return $this->post('/neptune/roles', [
            'name' => $name
        ]);
    }

}
