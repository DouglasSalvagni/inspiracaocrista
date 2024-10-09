jQuery(document).ready(function ($) {

    $('.phone-ddd-mask').mask('(00) 0000-00000');
    $('.preco-mask').mask('000.000.000.000.000,00', { reverse: true});
    $('.cep-mask').mask('00000-000');
    $('.cpf-mask').mask('000.000.000-00');
    $('.cnpj-mask').mask('00.000.000/0000-00');
    $('.data-mask').mask('00/00/0000');
    $('.cc-mask').mask('0000 0000 0000 0000');
    $('.cvv-mask').mask('0000');
    $('.ano-mask').mask('0000');
    $('.mes-mask').mask('00');
    $('.mil-mask').mask('0000');

});