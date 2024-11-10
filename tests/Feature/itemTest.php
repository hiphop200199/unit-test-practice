<?php

namespace Tests\Feature;

use App\Models\item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class itemTest extends TestCase
{

    use RefreshDatabase;

    /*
    呼叫名為items的API，接受GET請求
    回傳伺服器狀態碼為200 ok
    回傳資料型態為json
    回傳資料格式為陣列
    回傳資料結構是物件陣列，每個物件都包含content為名的key
    回傳資料筆數為10筆
    */
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

     /*
    呼叫名為item的API，接受GET請求
    回傳特定編號的item
    回傳伺服器狀態碼為200 ok
    回傳資料型態為json
    回傳資料結構是陣列，包含content為名的key
    回傳資料筆數為1筆
    */
    public function test_should_return_the_chosen_record()
    {
        $test_id = 300;
        item::factory()->create(['content'=>'測試.','id'=>$test_id]);
        $response = $this->get('/item/'.$test_id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'content'
        ]);

        $response->assertJsonCount(1);
    }
    /*
    呼叫名為create的API，接受POST請求
    認定資料庫內要有一筆['content'=>$test_data['content']]的資料
    回傳伺服器狀態碼為200 ok
    回傳資料型態為json
    回傳資料結構是陣列，包含message為名的key
    回傳資料包含['message'=>'create success.']片段
    回傳資料筆數為1筆
    */
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

    /*
    呼叫名為update的API，接受PUT請求
    認定資料庫內要有一筆['content'=>$test_data['content']]的資料
    回傳伺服器狀態碼為200 ok
    回傳資料型態為json
    回傳資料結構是陣列，包含message為名的key
    回傳資料包含['message'=>'update success.']片段
    回傳資料筆數為1筆
    */
    public function test_should_update_the_chosen_record()
    {
        item::factory(99)->create();

        $test_data = ['content'=>'測試.','id'=>250];

        item::factory()->create(['id'=>$test_data['id']]);

        $response = $this->put('update',$test_data);

        item::where('id','=',$test_data['id'])->update(['content'=>$test_data['content']]);

        $this->assertDatabaseHas('items',['content'=>$test_data['content']]);

        $response->assertStatus(200);

        $response->assertJsonStructure(['message']);

        $response->assertJsonFragment(['message'=>'update success.']);

        $response->assertJsonCount(1);
    }


    /*
    呼叫名為delete的API，接受DELETE請求
    認定資料庫內應該沒有指定id的資料
    回傳伺服器狀態碼為200 ok
    回傳資料型態為json
    回傳資料結構是陣列，包含message為名的key
    回傳資料包含['message'=>'delete success.']片段
    回傳資料筆數為1筆
    */
    public function test_should_delete_the_chosen_record()
    {
        item::factory(99)->create();

        $test_data = ['id'=>250];

        item::factory()->create(['id'=>$test_data['id']]);

        $response = $this->delete('delete',$test_data);

        item::destroy($test_data['id']);

        $this->assertDatabaseMissing('items',['id'=>$test_data['id']]);

        $response->assertStatus(200);

        $response->assertJsonStructure(['message']);

        $response->assertJsonFragment(['message'=>'delete success.']);

        $response->assertJsonCount(1);
    }
}
