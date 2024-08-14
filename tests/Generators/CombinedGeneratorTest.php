<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\CombinedGenerator;
use Axyr\CrudGenerator\Tests\TestCase;

class CombinedGeneratorTest extends TestCase
{
    public function testGenerateAllFiles(): void
    {
        $generator = new CombinedGenerator('Comment', 'Posts');

        $generator->generate();

        $expectedGeneratedFiles = [
            'app/Modules/Posts/Models/Comment.php',
            'app/Modules/Posts/Http/Controllers/CommentController.php',
            'app/Modules/Posts/Factories/CommentFactory.php',
            'app/Modules/Posts/Filters/CommentFilter.php',
            'app/Modules/Posts/Policies/CommentPolicy.php',
            'app/Modules/Posts/Repositories/CommentRepository.php',
            'app/Modules/Posts/Http/Requests/CommentRequest.php',
            'app/Modules/Posts/Http/Resources/CommentResource.php',
            'app/Modules/Posts/Seeders/CommentPermissionSeeder.php',
        ];

        $this->assertEquals($expectedGeneratedFiles, $generator->generatedFiles());
    }
}
