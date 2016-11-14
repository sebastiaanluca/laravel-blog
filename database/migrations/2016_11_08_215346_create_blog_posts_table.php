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
        $this->schema->create('blog_posts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 180)->unique()->index();
            
            $table->softDeletes();
            $table->timestamp('published_at');
            $table->boolean('is_draft')->default(true);
            
            $table->string('title', 180);
            $table->text('intro')->nullable();
            $table->mediumText('body');
            
            $table->timestamps();
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