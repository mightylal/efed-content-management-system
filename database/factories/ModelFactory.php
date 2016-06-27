<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Efed\Models\Wrestler::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'password' => bcrypt(str_random(10)),
        'slug' => str_slug($faker->userName),
        'age' => $faker->numberBetween(18, 65),
        'gender' => $faker->randomElement(['Male', 'Female']),
        'height' => $faker->numberBetween(50, 90),
        'weight' => $faker->numberBetween(100, 500),
        'bio' => $faker->paragraph,
        'activated' => 1,
        'remember_token' => str_random(10),
    ];
});

$factory->define(Efed\Models\Roleplay::class, function (Faker\Generator $faker) {
    return [
        'wrestler_id' => factory(Efed\Models\Wrestler::class)->create()->id,
        'event_id' => factory(Efed\Models\Event::class)->create()->id,
        'fed_score' => $faker->numberBetween(0, 10),
        'rp' => $faker->text(),
        'name' => $faker->sentence(6),
    ];
});

$factory->define(Efed\Models\Forum::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(25),
        'description' => $faker->sentence,
        'access' => 'Everyone',
        'posting' => 'Everyone',
    ];
});

$factory->define(Efed\Models\ForumPost::class, function (Faker\Generator $faker) {
    return [
        'topic_id' => factory(Efed\Models\ForumTopic::class)->create()->id,
        'wrestler_id' => factory(Efed\Models\Wrestler::class)->create()->id,
        'post' => $faker->text(),
    ];
});

$factory->define(Efed\Models\ForumTopic::class, function (Faker\Generator $faker) {
    return [
        'category_id' => factory(Efed\Models\Forum::class)->create()->id,
        'wrestler_id' => factory(Efed\Models\Wrestler::class)->create()->id,
        'name' => $faker->sentence(),
    ];
});

$factory->define(Efed\Models\Staff::class, function (Faker\Generator $faker) {
    return [
        'wrestler_id' => factory(Efed\Models\Wrestler::class)->create()->id,
    ];
});

$factory->define(Efed\Models\Page::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'content' => $faker->paragraph,
        'access' => 'Everyone',
        'placement' => 200,
    ];
});

$factory->define(Efed\Models\Message::class, function (Faker\Generator $faker) {
    return [
        'subject' => $faker->sentence,
    ];
});

$factory->define(Efed\Models\MessageBody::class, function (Faker\Generator $faker) {
    return [
        'message_id' => factory(Efed\Models\Message::class)->create()->id,
        'wrestler_id' => factory(Efed\Models\Wrestler::class)->create()->id,
        'message' => $faker->paragraph,
    ];
});

$factory->define(Efed\Models\MessageWrestler::class, function (Faker\Generator $faker) {
    return [
        'message_id' => factory(Efed\Models\MessageBody::class)->create()->message_id,
        'wrestler_id' => factory(Efed\Models\Wrestler::class)->create()->id,
    ];
});

$factory->define(Efed\Models\Title::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'type' => 'Single',
    ];
});

$factory->define(Efed\Models\TitleReign::class, function (Faker\Generator $faker) {
    return [
        'title_id' => factory(Efed\Models\Title::class)->create()->id,
        'date_won' => date('Y-m-d'),
    ];
});

$factory->define(Efed\Models\Settings::class, function (Faker\Generator $faker) {
    return [
        'roleplayLimit' => $faker->numberBetween(1, 10),
        'gradeRights' => $faker->randomElement(['Everyone', 'Staff']),
        'content' => $faker->text,
    ];
});

$factory->define(Efed\Models\Style::class, function (Faker\Generator $faker) {
    return [
        'name' => 'default',
        'primary1' => $faker->randomNumber(6),
        'primary2' => $faker->randomNumber(6),
        'secondary1' => $faker->randomNumber(6),
        'secondary2' => $faker->randomNumber(6),
        'secondary3' => $faker->randomNumber(6),
        'secondary4' => $faker->randomNumber(6),
    ];
});

$factory->define(Efed\Models\Event::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(25),
        'scheduled_at' => date('Y-m-d'),
        'preview' => $faker->paragraph,
        'deadline_at' => date('Y-m-d', -1),
    ];
});

$factory->define(Efed\Models\Segment::class, function (Faker\Generator $faker) {
    return [
        'event_id' => factory(Efed\Models\Event::class)->create()->id,
        'title_id' => 0,
        'type' => 0,
        'name' => $faker->text(15),
        'result' => $faker->paragraph,
    ];
});

$factory->define(Efed\Models\SegmentWrestler::class, function (Faker\Generator $faker) {
    return [
        'segment_id' => factory(Efed\Models\Segment::class)->create()->id,
        'wrestler_id' => factory(Efed\Models\Segment::class)->create()->id,
        'team_id' => 1,
    ];
});