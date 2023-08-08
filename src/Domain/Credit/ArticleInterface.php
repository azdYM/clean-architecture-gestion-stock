<?php

namespace App\Domain\Credit;

use App\Domain\Credit\ParameterInDescriptionInterface;


/**
 * Une interface qui represente les articles contenus dans les contracts. Un article peut 
 * contenir plusieurs proprietés comme le capital, le taux d'interêt ...etc et d'autre phrase qui 
 * demeure invariable. c'est à dire que pour tous les contrats on a les articles associés dont seul 
 * les propriétés peut varier d'un contrat a l'autre. Ce qui fait qu'un article possede une description 
 * et des parametres
 */
interface ArticleInterface extends ParameterInDescriptionInterface
{
    public function getTitle(): string;

    public function getDescription(): string;

    public function setArticle(string $title, string $description): self;
}