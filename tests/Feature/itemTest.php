<?php

namespace Tests\Feature;

use App\Models\item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class itemTest extends TestCase
{
    /*
    呼叫名為items的API，接受GET請求
    回傳伺服器狀態碼為200 ok
    回傳資料型態為json
    回傳資料格式為陣列
    回傳資料結構是物件陣列，每個物件都包含content為名的key
    回傳資料筆數為10筆
    */
    use RefreshDatabase;
    public function test_should_return_ten_contents_records(): void
    {
        item::factory(100)->create();

        $response = $this->get('/items');

        $response->assertStatus(200);

        $response->assertJsonIsArray();

        $response->assertJsonStructure([
            '*'=>['content']
        ]);

        $response->assertJsonCount(10);


    }

    public function test_should_create_a_new_record()
    {
        $test_data = ['content'=>'測試.'];

        $response = $this->post('create',$test_data);

        item::factory()->create(['content'=>$test_data['content']]);

        $this->assertDatabaseHas('items',['content'=>$test_data['content']]);

        $response->assertStatus(200);

        $response->assertJsonStructure(['message']);

        $response->assertJsonFragment(['message'=>'create success.']);

        $response->assertJsonCount(1);
    }
}
