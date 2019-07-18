<?php
/**
 * Created by PhpStorm.
 * User: Maranatha
 * Date: 17/07/2019
 * Time: 20:41
 */

namespace App\DQL;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

class SubtimeFunction extends FunctionNode
{


    protected $dateExpression =null;

    protected $intervalExpression =null;


    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);


        $this->dateExpression = $parser->ArithmeticPrimary();


        $parser->match(Lexer::T_COMMA);

        $this->dateExpression = $parser->ArithmeticPrimary();


        $this->intervalExpression = $parser->ArithmeticPrimary();


        $parser->match(Lexer::T_CLOSE_PARENTHESIS);

    }




    public function getSql(SqlWalker $sqlWalker)
    {
        return 'SUBTIME('
            . $this->dateExpression->dispatch($sqlWalker)
            . ' ,'
            . $this->intervalExpression->dispatch($sqlWalker)
            . ')';
    }



}