<?php

declare(strict_types=1);

namespace UI\Cli\Command;

use App\EquipmentRegister\Domain\Equipment\Equipment;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentProperty;
use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryName;
use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerName;
use App\EquipmentRegister\Domain\EquipmentTemplate\Enum\EquipmentTemplatePropertyType;
use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateName;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateProperty;
use App\Shared\CommonUtilities\ReflectionUtils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'testcommand', description: 'Hello PhpStorm')]
class TestCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct('testcommand');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Lecimy kurwa");

        try {
            $this->doIt($output);
        } catch (\Throwable $e) {
            $output->writeln($e->getMessage() . "\n" . $e->getTraceAsString());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function doIt(OutputInterface $output): void
    {
//        $this->manufacturers();
//        $this->categories();
//        $this->properties();
        $this->report($output);
    }

    private function report(OutputInterface $output): void
    {
        $c = $this->entityManager->getConnection();
        $stmt = $c->prepare($this->turboSql());
        $results = $stmt->executeQuery()
            ->fetchAllAssociative();

        dd($results);

            $output->writeln(':)');
    }

    private function turboSql(): string
    {
        return "
            SELECT * from equipment e
            INNER JOIN equipment_template et ON et.id = e.equipment_template_id
         ";
    }

    private function properties(): void
    {
        $usable = EquipmentTemplateProperty::create(EquipmentTemplatePropertyType::YES_NO, 'isUsable', 1);
        $description = EquipmentTemplateProperty::create(EquipmentTemplatePropertyType::TEXT, 'description', 2);
        $price = EquipmentTemplateProperty::create(EquipmentTemplatePropertyType::DECIMAL, 'price', 3);

        $this->entityManager->persist($usable);
        $this->entityManager->persist($description);
        $this->entityManager->persist($price);

        $google = $this->entityManager->getRepository(EquipmentManufacturer::class)->findBy(['name.name' => 'Google']
        )[0];
        $microsoft = $this->entityManager->getRepository(EquipmentManufacturer::class)->findBy(
            ['name.name' => 'Microsoft']
        )[0];

        $hose = $this->entityManager->getRepository(EquipmentCategory::class)->findBy(['name.name' => 'Hose'])[0];
        $openHelmet = $this->entityManager->getRepository(EquipmentCategory::class)->findBy(
            ['name.name' => 'Open helmet']
        )[0];

        $name = EquipmentTemplateName::fromString('Open Helmet Google');
        $helmetGoogleOpen = EquipmentTemplate::create(
            $name,
            $openHelmet,
            $google,
            new ArrayCollection([$usable, $description])
        );

        $name = EquipmentTemplateName::fromString('Hose Microsoft');
        $hoseMicrosoft = EquipmentTemplate::create(
            $name,
            $hose,
            $microsoft,
            new ArrayCollection([$price, $description])
        );

        $this->entityManager->persist($hoseMicrosoft);
        $this->entityManager->persist($helmetGoogleOpen);

        $hoseMicrosoft1 = Equipment::create($hoseMicrosoft);
        $p1 = EquipmentProperty::create($price, '55,22', 1, $hoseMicrosoft1);
        $p2 = EquipmentProperty::create($description, 'first hose', 2, $hoseMicrosoft1);
        $this->entityManager->persist($hoseMicrosoft1);
        $this->entityManager->persist($p1);
        $this->entityManager->persist($p2);

        $hoseMicrosoft1 = Equipment::create($hoseMicrosoft);
        $p1 = EquipmentProperty::create($price, '335,22', 1, $hoseMicrosoft1);
        $p2 = EquipmentProperty::create($description, 'second hose', 2, $hoseMicrosoft1);
        $this->entityManager->persist($hoseMicrosoft1);
        $this->entityManager->persist($p1);
        $this->entityManager->persist($p2);

        $helmet = Equipment::create($helmetGoogleOpen);
        $p1 = EquipmentProperty::create($usable, 'Yes', 1, $helmet);
        $p2 = EquipmentProperty::create($description, 'second hose', 2, $helmet);
        $this->entityManager->persist($helmet);
        $this->entityManager->persist($p1);
        $this->entityManager->persist($p2);

        $this->entityManager->flush();
    }

    private function categories(): void
    {
        $name = EquipmentCategoryName::fromString('Helmet');
        $helmet = EquipmentCategory::create($name);
        $this->entityManager->persist($helmet);

        $name = EquipmentCategoryName::fromString('Hose');
        $category = EquipmentCategory::create($name);
        $this->entityManager->persist($category);

        $name = EquipmentCategoryName::fromString('Closed helmet');
        $category = EquipmentCategory::create($name, $helmet);
        $this->entityManager->persist($category);

        $name = EquipmentCategoryName::fromString('Open helmet');
        $category = EquipmentCategory::create($name, $helmet);
        $this->entityManager->persist($category);

        $this->entityManager->flush();
    }

    private function manufacturers(): void
    {
        $name = EquipmentManufacturerName::fromString("Microsoft");
        $sampleManufacturer = EquipmentManufacturer::create($name);
        $this->entityManager->persist($sampleManufacturer);

        $name = EquipmentManufacturerName::fromString("OTTO");
        $sampleManufacturer = EquipmentManufacturer::create($name);
        $this->entityManager->persist($sampleManufacturer);

        $name = EquipmentManufacturerName::fromString("Google");
        $sampleManufacturer = EquipmentManufacturer::create($name);
        $this->entityManager->persist($sampleManufacturer);

        $this->entityManager->flush();
    }

}
