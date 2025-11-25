const botoesExpandir = document.getElementsByClassName("botao-expandir");

for (let element of botoesExpandir) {
    element.onclick = () => {
        let containerPecas = element.parentElement.querySelector(".lista-item-expansivel-pecas")
        containerPecas.classList.toggle("disabled");

        if (containerPecas.classList.contains("disabled")) {
            element.querySelector("img").src = "../img/Abrir.png";
        } else {
            element.querySelector("img").src = "../img/Fechar.png";
        }
    }
};
