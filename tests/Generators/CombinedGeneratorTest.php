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
            'app-modules/Posts/src/Models/Comment.php',
            'app-modules/Posts/src/Http/Controllers/CommentController.php',
            'app-modules/Posts/src/Factories/CommentFactory.php',
            'app-modules/Posts/src/Filters/CommentFilter.php',
            'app-modules/Posts/src/Policies/CommentPolicy.php',
            'app-modules/Posts/src/Repositories/CommentRepository.php',
            'app-modules/Posts/src/Http/Requests/CommentRequest.php',
            'app-modules/Posts/src/Http/Resources/CommentResource.php',
            'app-modules/Posts/src/Seeders/CommentPermissionSeeder.php',
            'app-modules/Posts/src/PostServiceProvider.php',
            'app-modules/Posts/composer.json',
            'app-modules/Posts/routes.php',
            'app-modules/Posts/tests/Http/Controllers/CommentControllerAuthorizationTest.php',
            'app-modules/Posts/tests/Http/Controllers/CommentControllerTest.php',
        ];

        $this->assertEquals($expectedGeneratedFiles, $generator->generatedFiles());
    }
}
