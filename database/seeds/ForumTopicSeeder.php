<?php

use Illuminate\Database\Seeder;

class ForumTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topics = factory(Efed\Models\ForumTopic::class, 50)->create();
        foreach ($topics as $topic) {
            factory(Efed\Models\ForumPost::class)->create(['topic_id' => $topic->id]);
        }
    }
}
