<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "zenn",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "belajar"
                ],
                [
                    "id" => "2",
                    "todo" => "coding"
                ]
            ]
        ])->get("/todolist")
            ->assertSeeText("1")
            ->assertSeeText("belajar")
            ->assertSeeText("2")
            ->assertSeeText("coding");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "zenn",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "belajar"
                ],
                [
                    "id" => "2",
                    "todo" => "coding"
                ]
            ]
        ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }


}
