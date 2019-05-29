<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\NeptuneRole;
use App\NeptuneContract;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NeptuneContractTest extends TestCase
{
    // Refresh database with all tests
    use RefreshDatabase;

    /** @test */
    public function a_contract_can_be_created()
    {
        // Disable the default Laravel exception handling
        $this->withoutExceptionHandling();

        // Act as a user
        $this->actAsUser();

        // Try to create a new contract trhough route acting as the user
        $response = $this->createContract();

        // Check if user is redirected to neptune
        $response->assertRedirect(route('neptune.contracts.show', NeptuneContract::first()->id));

        // Check if contract was created
        $this->assertCount(1, NeptuneContract::all());


    }

    /** @test */
    public function contract_code_is_required()
    {
        // Act as a user
        $this->actAsUser();

        // Create contract as the user
        $response = $this->createContract('');

        // Check if session has errors for number
        $response->assertSessionHasErrors('code');
    }

    /** @test */
    public function contract_name_is_required()
    {
        // Act as a user
        $this->actAsUser();

        // Create contract as the user
        $response = $this->createContract(1, '');

        // Check if session has errors for number
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_contract_can_be_updated()
    {
        // Disable default Laravel exception handling
        $this->withoutExceptionHandling();

        // Act as a user
        $this->actAsUser();

        // Create a contract as the user
        $this->createContract();

        // Get the contract
        $contract = NeptuneContract::first();

        // Try to update the contract through route
        $response = $this->patch($contract->path(), [
            'name' => 'new name'
        ]);

        // Check if the user is redirected to the contract
        $response->assertRedirect(route('neptune.contracts.show', $contract->id));

        // Check if the update was successful
        $this->assertEquals('new name', $contract->fresh()->name);
    }

    /** @test **/
    public function a_contract_can_be_deleted()
    {
        // Disable default Laravel exception handling
        $this->withoutExceptionHandling();

        // Act as a suer
        $this->actAsUser();

        // Create a contract as the user
        $this->createContract();

        // Check if contract was created
        $this->assertCount(1, NeptuneContract::all());

        // Get the contract
        $contract = NeptuneContract::first();

        // Try to delete the contract through route
        $response= $this->delete($contract->path());

        // Check if the user is redirected to neptune index
        $response->assertRedirect(route('neptune.index'));

        // Check of the contract was deleted
        $this->assertCount(0, NeptuneContract::all());
    }

    /** @test */
    public function a_contract_can_be_added_to_a_neptune_role()
    {
        // Disable default Laravel exception handling
        $this->withoutExceptionHandling();

        // Act as a user
        $this->actAsUser();

        // Create a contract
        $this->createContract();

        // Get the contract
        $contract = NeptuneContract::first();

        // Add contract to a neptune role
        $this->patch($contract->path(), [
            'role_id' => 1
        ]);

        // Check if the contract was added to the role
        $this->assertEquals(1, $contract->fresh()->role_id);
    }

    /** @test */
    public function a_contract_belongs_to_role_relationship()
    {
        // Create two contracts
        factory(NeptuneRole::class, 2)->create();

        // Check of contracts was created
        $this->assertCount(2, NeptuneRole::all());

        // Get the role class
        $contract = new NeptuneContract;

        // Check if the role has one-to-many relationship to contracts
        $this->assertInstanceOf(BelongsTo::class, $contract->role());
    }



    /* # Helpers # */

    protected function actAsUser()
    {
        // Create a user
        factory(User::class, 1)->create();

        // Act as the user
        return $this->actingAs(User::first());
    }

    protected function createContract($code = 1, $name = 'Anställd')
    {
        return $this->post('/neptune/contracts', [
            'code' => $code,
            'name' => $name
        ]);
    }

}
