<?php

namespace App\Infrastructure\DataFixtures\Credit;

use App\Domain\Contract\Components\Article;
use App\Domain\Contract\Components\GeneralContent;
use App\Domain\Contract\Components\SignatureLabel;
use App\Domain\Contract\Entity\GageContract;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class GageCreditContractFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['group3'];
    }

    public function load(ObjectManager $manager)
    {
        $content = (new GeneralContent())
            ->setDescription(
                "Capital : | {capital} |
                Durée : | {period} |
                Début : | {started} |
                Fin : | {end} |
                Intérêt : | {interest} |
                Poids gage : | {weight} |
                Numéro de contrat de Prêt MECK-Moroni : | {idFolderAdbanking} |
                Numéro de dossier : | {folder} |

                D'une part, représenté par La DIRECTRICE EXECUTIVE (Prêteur)
                Et {name}, autrement connu sous le nom de {surnom}
                Date de naissance : | {birthDay} |
                Lieu de naissance : | {birthLocation} |

                Ci-après dénommé « le débiteur » d'autre part,

                Adresse actuelle : | {ActualLocation} |
                Origine : | {location} |
                Téléphone : | {tel} |
                Lieu de travail : | {professionCite} |
                NIN : | {nin} |
                Autres personnes à contacter : | {anotherPerson} |
                Lien : | {link} |
                Lieu de travail : | {professionaCite} |
                Téléphone : | {anotherPersonTel} |
                "
            )
            ->setContractType(GageContract::class)
        ;

        $oneArticle = (new Article())
            ->setArticle(
                "Exposé des motifs",
                "Dans un souci de vouloire reduire .... bla bla ... okay c'est bon je suis éclaté
                annexant au contrat de prêt N° {idCredit}, en date du {date} bla bla ....
                "
            )
            ->setContractType(GageContract::class)
        ;

        $twoArticle = (new Article())
            ->setArticle(
                "Article 1 : Object du contrat",
                "En signant son contrat de prêt à la meck-moroni, le membre débiteur
                souscrit également et automatiquement la dite bla bla bla .....
                "
            )
            ->setContractType(GageContract::class)
        ;

        $threeArticle = (new Article())
            ->setArticle(
                "Article 2 : Condition d'admissibilité",
                "Seuls sont admissibles à la sousciption au fonds de solidarité, lors d'une
                demande bla bla bla .....
                "
            )
            ->setContractType(GageContract::class)
        ;

        $oneSignature = (new SignatureLabel())
            ->setLabel('Membre Emprunteur')
            ->setContractType(GageContract::class)
        ;

        $threeSignature = (new SignatureLabel())
            ->setLabel('Directrice Exécutive')
            ->setContractType(GageContract::class)
        ;

        $twoSignature = (new SignatureLabel())
            ->setLabel('Chef Service crédit & Engagement')
            ->setContractType(GageContract::class)
        ;

        $fourSignature = (new SignatureLabel())
            ->setLabel('Chargé de prêt')
            ->setContractType(GageContract::class)
        ;
        
        $manager->persist($content);
        $manager->persist($oneArticle);
        $manager->persist($twoArticle);
        $manager->persist($threeArticle);
        $manager->persist($oneSignature);
        $manager->persist($twoSignature);
        $manager->persist($threeSignature);
        $manager->persist($fourSignature);


        $manager->flush();
    }	
}