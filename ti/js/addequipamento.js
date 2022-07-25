function tipoEquipamento() {
    var optvalue = document.getElementById("tipo_equipamento").value;



    if (optvalue == 1 || optvalue == 2) { //TABLET E CELULAR

        document.getElementById("celularTablet").style.display = "block";

        document.getElementById("nota").style.display = "block";

        document.getElementById("chipModem").style.display = "none";

        document.getElementById("ramalIP").style.display = "none";

        document.getElementById("dvr").style.display = "none";

        document.getElementById("scanner").style.display = "none";

        document.getElementById("cpuNotebook").style.display = "none";

        document.getElementById("salvarButton").style.display = "block";

        document.getElementById("colaborador").style.display = "block";

        document.getElementById("hREDE").style.display = "none";

    } else if (optvalue == 3 || optvalue == 4) { //CHIP E MODEM

        document.getElementById("celularTablet").style.display = "none";

        document.getElementById("chipModem").style.display = "block";

        document.getElementById("nota").style.display = "block";

        document.getElementById("ramalIP").style.display = "none";

        document.getElementById("dvr").style.display = "none";

        document.getElementById("scanner").style.display = "none";

        document.getElementById("cpuNotebook").style.display = "none";

        document.getElementById("salvarButton").style.display = "block";

        document.getElementById("colaborador").style.display = "block";

        document.getElementById("hREDE").style.display = "none";

    } else if (optvalue == 5) { //RAMAL IP

        document.getElementById("celularTablet").style.display = "none";

        document.getElementById("chipModem").style.display = "none";

        document.getElementById("nota").style.display = "none";

        document.getElementById("ramalIP").style.display = "block";

        document.getElementById("dvr").style.display = "none";

        document.getElementById("scanner").style.display = "none";

        document.getElementById("cpuNotebook").style.display = "none";

        document.getElementById("salvarButton").style.display = "block";

        document.getElementById("colaborador").style.display = "block";

        document.getElementById("hREDE").style.display = "none";

    } else if (optvalue == 8 || optvalue == 9) { //CPU E NOTEBOOK

        document.getElementById("celularTablet").style.display = "none";

        document.getElementById("chipModem").style.display = "none";

        document.getElementById("nota").style.display = "none";

        document.getElementById("ramalIP").style.display = "none";

        document.getElementById("salvarButton").style.display = "none";

        document.getElementById("cpuNotebook").style.display = "block";

        document.getElementById("dvr").style.display = "none";

        document.getElementById("scanner").style.display = "none";

        document.getElementById("colaborador").style.display = "none";

        document.getElementById("tabelaFun").style.display = "none";

        document.getElementById("hREDE").style.display = "none";

    } else if (optvalue == 10) { //SCANNER

        document.getElementById("celularTablet").style.display = "none";

        document.getElementById("chipModem").style.display = "none";

        document.getElementById("nota").style.display = "none";

        document.getElementById("ramalIP").style.display = "none";

        document.getElementById("salvarButton").style.display = "block";

        document.getElementById("cpuNotebook").style.display = "none";

        document.getElementById("dvr").style.display = "none";

        document.getElementById("scanner").style.display = "block";

        document.getElementById("colaborador").style.display = "block";

        document.getElementById("hREDE").style.display = "none";

    } else if (optvalue == 11) { //DVR

        document.getElementById("celularTablet").style.display = "none";

        document.getElementById("chipModem").style.display = "none";

        document.getElementById("nota").style.display = "none";

        document.getElementById("ramalIP").style.display = "none";

        document.getElementById("salvarButton").style.display = "block";

        document.getElementById("cpuNotebook").style.display = "none";

        document.getElementById("dvr").style.display = "block";

        document.getElementById("scanner").style.display = "none";

        document.getElementById("colaborador").style.display = "block";

        document.getElementById("hREDE").style.display = "none";

    } else if (optvalue == 12) { //HARDWARE REDE

        document.getElementById("celularTablet").style.display = "none";

        document.getElementById("chipModem").style.display = "none";

        document.getElementById("nota").style.display = "block";

        document.getElementById("ramalIP").style.display = "none";

        document.getElementById("salvarButton").style.display = "block";

        document.getElementById("cpuNotebook").style.display = "none";

        document.getElementById("dvr").style.display = "none";

        document.getElementById("scanner").style.display = "none";

        document.getElementById("colaborador").style.display = "none";

        document.getElementById("hREDE").style.display = "block";

    }
} //FIM FUNÇÂO


function a() {

    var optvalue = document.getElementById("situacaoscan").value;

    if (optvalue == 4) {

        document.getElementById("alugado").style.display = "block";

        document.getElementById("comprado").style.display = "none";

    } else if (optvalue == 5) {

        document.getElementById("alugado").style.display = "none";

        document.getElementById("comprado").style.display = "block";

    } else {

        document.getElementById("alugado").style.display = "none";

        document.getElementById("comprado").style.display = "none";
    }

} //FIM FUNÇÂO