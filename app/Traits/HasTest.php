<?php
namespace App\Traits;

trait HasTest {
    public function test_seeders_works()
    {
        $model = new $this->model();
        $this->assertTrue($this->count > 0);
        $this->assertDatabaseCount($model->getTable(), $this->countWithTrashed);
    }

    public function test_index()
    {
        $response = $this->actingAs($this->user, 'api')->json('GET', $this->api);
        $response->assertOk();
        $response->assertJsonCount($this->count);
    }

    public function test_show()
    {
        $id = $this->model::first()->id;
        $response = $this->actingAs($this->user, 'api')->get($this->api . "/" . $id);
        $response->assertOk();
        $response->assertJson(['id' => $id]);
    }

    public function test_store()
    {
        $data = $this->model::factory()->make()->toArray();

        $response = $this->actingAs($this->user, 'api')->post($this->api, $data);

        $object = new $this->model ;

        $response->assertCreated();
        $response->assertJsonStructure(array_keys($data));
        $this->assertDatabaseCount($object->getTable(), $this->countWithTrashed + 1);
    }

    public function test_update()
    {
        $original = $this->model::factory()->create();

        $data = $this->model::factory()->make();

        $id = $original->id;

        $response = $this->actingAs($this->user, 'api')->put($this->api . "/" . $id, $data->toArray());
        $response->assertOk();
        $response->assertJson(['id' => $id]);
    }

    public function test_destroy()
    {
        $model = $this->model::factory()->create();
        $response = $this->actingAs($this->user, 'api')->delete($this->api . "/" . $model->id);

        $response->assertOk();
        $response->assertjson(['id' => $model->id]);

        $this->assertDatabaseHas($model->getTable(), [
            'id' => $model->id,
        ]);
        $this->assertSoftDeleted($model);
    }
}
