<?php

use Illuminate\Database\Schema\Blueprint;
use SebastiaanLuca\Migrations\TransactionalMigration as Migration;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function migrateUp()
    {
        $this->schema->create('blog_posts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('slug', 191)->unique()->index();

            $table->string('title', 191);
            $table->text('intro')->nullable();
            $table->mediumText('body');

            $table->timestamp('published_at')->nullable();
            $table->boolean('is_draft')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function migrateDown()
    {
        $this->drop('blog_posts');
    }
}