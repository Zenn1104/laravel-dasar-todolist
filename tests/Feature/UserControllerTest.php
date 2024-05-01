<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
   public function testLoginPage()
   {
       $this->get('/login')
           ->assertSeeText("Login Todolist Zenn");
   }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "zenn"
        ])->get("/login")
            ->assertRedirect("/");
    }


    public function testLoginSuccess()
   {
       $this->post('/login', [
           "user" => "zenn",
           "password" => "rahasia"
       ])
           ->assertRedirect("/")
            ->assertSessionHas("user", "zenn");
   }

    public function testLoginForUserAlreadyExist()
    {
        $this->withSession([
            "user" => "zenn"
        ])
            ->post('/login', [
            "user" => "zenn",
            "password" => "rahasia"
        ])
            ->assertRedirect("/");
    }


    public function testLoginValidationError()
   {
       $this->post("/login", [])
           ->assertSeeText("User or Password is required!");
   }

   public function testLoginFailed()
   {
       $this->post("/login", [
           "user" => "wrong",
           "password" => "wrong"
       ])
           ->assertSeeText("User or Password is wrong!");
   }

    public function testLogout()
    {
        $this->withSession([
            "user" => "zenn"
        ])->post("/logout")
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post("/logout")
            ->assertRedirect("/");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "zenn"
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required!");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "zenn"
        ])->post("/todolist", [
            "todo" => "belajar"
        ])->assertRedirect("/todolist");
    }


}
