<?php

use App\DA\Repository\MSCommentRepository;
use App\DA\Repository\MSFileRepository;
use App\DA\Repository\MSGroupRepository;
use App\DA\Repository\MSLabRepository;
use App\DA\Repository\MSSolutionRepository;
use App\DA\Repository\MSUserRepository;
use App\Domain\Repository\ICommentRepository;
use App\Domain\Repository\IFileRepository;
use App\Domain\Repository\IGroupRepository;
use App\Domain\Repository\ILabRepository;
use App\Domain\Repository\ISolutionRepository;
use App\Domain\Repository\IUserRepository;
use App\Domain\Storage\ILabFileStorage;
use App\Domain\Storage\ISolutionFileStorage;
use App\Domain\Storage\Mock\FSLabFileStorage;
use App\Domain\Storage\Mock\FSSolutionFileStorage;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container): void {
    // default configuration for services in *this* file
    $services = $container->services()
        ->defaults()
        ->autowire()      // Automatically injects dependencies in your services.
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
    ;

    // makes classes in src/ available to be used as services
    // this creates a service per class whose id is the fully-qualified class name
    $services->load('App\\', '../src/')
        ->exclude('../src/{DependencyInjection,Entity,Kernel.php}');

    // order is important in this file because service definitions
    // always *replace* previous ones; add your own service configuration below

    $services->set(ICommentRepository::class, MSCommentRepository::class);
    $services->set(IFileRepository::class, MSFileRepository::class);
    $services->set(IGroupRepository::class, MSGroupRepository::class);
    $services->set(ILabRepository::class, MSLabRepository::class);
    $services->set(ISolutionRepository::class, MSSolutionRepository::class);
    $services->set(IUserRepository::class, MSUserRepository::class);

    $services->set(ISolutionFileStorage::class, FSSolutionFileStorage::class);
    $services->set(ILabFileStorage::class, FSLabFileStorage::class);
};