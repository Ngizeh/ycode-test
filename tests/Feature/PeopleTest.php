<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PeopleTest extends TestCase
{
    public function validData($parameters = []): array
    {
        Storage::fake('avatars');

        return array_merge([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'photo' => UploadedFile::fake()->image('photo.jpg')->size(100000)
        ], $parameters);
    }

    /** @test **/
    public function it_can_add_people_successful()
    {        
        $attributes = $this->validData();

        $response = $this->postJson('people', $attributes);
        
        $response->assertStatus(201);
    }

    /** @test **/
    public function name_is_required_in_form_field()
    {
        $attributes = $this->validData(['name' => null]);

        $response = $this->postJson('people', $attributes);

        $response->assertJsonValidationErrors('name');
    }

    /** @test **/
    public function avatar_not_more_than_100_MB()
    {
        $attributes = $this->validData([
            'photo' => UploadedFile::fake()->image('avatar.jpg')->size(100001)
        ]);

        $response = $this->postJson('people', $attributes);

        $response->assertJsonValidationErrors('photo');
    }

    /** @test **/
    public function avatar_png_mimes_not_allowed()
    {
        $attributes = $this->validData([
            'photo' => UploadedFile::fake()->image('avatar.png')
        ]);

        $response = $this->postJson('people', $attributes);

        $response->assertJsonValidationErrors('photo');
    }

    /** @test **/
    public function email_is_required_in_form_field()
    {
        $attributes =  $this->validData(['email' => '']);

        $response = $this->postJson('people', $attributes);

        $response->assertJsonValidationErrors('email');
    }
    /** @test **/
    public function valid_email_is_required_in_form_field()
    {
        $attributes = $this->validData(['email' => 'not-valid-email']);

        $response = $this->postJson('people', $attributes);

        $response->assertJsonValidationErrors('email');
    }
}
