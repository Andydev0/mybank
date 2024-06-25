// /assets/js/script.js
const menuSobre = document.querySelector("#menu-sobre");
const dialogSobre = document.querySelector("#dialog-sobre");
const cabecalhoLocalizacaoImg = document.querySelector(".cabecalho-localizacao-img");
const dialogLocalizacao = document.querySelector("#dialog-localizacao");
const botaoDialogSobreFechar = document.querySelector("#botao-dialog-sobre-fechar");
const botaoSobreLocalizacaoFechar = document.querySelector("#botao-dialog-localizacao-fechar");

menuSobre.onclick = function () {
    dialogSobre.showModal();
};

cabecalhoLocalizacaoImg.onclick = function () {
    dialogLocalizacao.showModal();
};

botaoDialogSobreFechar.onclick = function () {
    dialogSobre.close();
};

botaoSobreLocalizacaoFechar.onclick = function () {
    dialogLocalizacao.close();
};
