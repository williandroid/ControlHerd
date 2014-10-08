<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script>

            var DadosClientes = [
                {ssn: "444-44-4444", nome: "Bill", idade: 35, email: "bill@company.com"},
                {ssn: "555-55-5555", nome: "Donna", idade: 32, email: "donna@home.org"},
                {ssn: "555-55-5551", nome: "Will", idade: 24, email: "ottoni@gmail.com"}
            ];

            // Abrindo o banco de dados
            var request = window.indexedDB.open("DB_GadoOn", 4);

            request.onsuccess = function(event) {
                // Fazer algo com request.result!
                var db = request.result;
            };

            // Este evento é implementado somente em navegadores mais recentes
            //EXECUTA SOMENTE UMA VEZ
            request.onupgradeneeded = function(event) {
                var db = event.target.result;

                // Cria um objectStore para conter a informação sobre nossos clientes. Nós vamos
                // usar "ssn" como key path porque sabemos que é único;
                var objectStore = db.createObjectStore("clientes", {keyPath: "ssn"});

                // Cria um índice para buscar clientes pelo nome. Podemos ter nomes
                // duplicados, então não podemos usar como índice único.
                objectStore.createIndex("nome", "nome", {unique: false});

                // Cria um índice para buscar clientes por email. Queremos ter certeza
                // que não teremos 2 clientes com o mesmo e-mail;
                objectStore.createIndex("email", "email", {unique: true});

//                // Usando transação oncomplete para afirmar que a criação do objectStore 
//                // é terminada antes de adicionar algum dado nele.
//                objectStore.transaction.oncomplete = function(event) {
//                    // Armazenando valores no novo objectStore.
//                    var clientesObjectStore = db.transaction("clientes", "readwrite").objectStore("clientes");
//                    for (var i in DadosClientes) {
//                        clientesObjectStore.add(DadosClientes[i]);
//                    }
//                }


            };
            inserir();
            listarTodos();
            buscar();
            function inserir() {

                var dbRequest = window.indexedDB.open('DB_GadoOn', 4);
                dbRequest.onsuccess = function(event) {
                    var db = dbRequest.result;
                    var db = event.target.result;

                    var myTransaction = db.transaction(["clientes"], "readwrite");
                    var myObjectStore = myTransaction.objectStore("clientes");

                    var inserir = myObjectStore.add({ssn: "111111111", nome: "Zé", idade: 18, email: "ze@company.com"});

                };
            };
            

            function listarTodos() {

                var dbRequest = window.indexedDB.open('DB_GadoOn', 4);
                dbRequest.onsuccess = function(event) {
                    var db = dbRequest.result;
                    var db = event.target.result;
                    //abre a transação com o nome do armazem de dados e somente leitura
                    var myTransaction = db.transaction(["clientes"], "readonly");
                    var myObjectStore = myTransaction.objectStore("clientes");

                    var cursor = myObjectStore.openCursor();

                    cursor.addEventListener("success", mostraTodosDados, false);

                };
            };

            function buscar() {

                var dbRequest = window.indexedDB.open('DB_GadoOn', 4);
                dbRequest.onsuccess = function(event) {
                    var db = dbRequest.result;
                    var db = event.target.result;
                    //abre a transação com o nome do armazem de dados e somente leitura
                    var myTransaction = db.transaction(["clientes"], "readonly");
                    var myObjectStore = myTransaction.objectStore("clientes");

                    var request = myObjectStore.get("444-44-4444");
                    request.onerror = function(event) {
                        // Tratar erro!
                    };
                    request.onsuccess = function(event) {
                        // Fazer algo com request.result!
                        //alert("O nome do SSN 444-44-4444 é " + request.result.nome);
                        //alert("A idade do SSN 444-44-4444 é " + request.result.idade);
                        //alert("A email do SSN 444-44-4444 é " + request.result.email);
                    };
                };
            };

            function mostraTodosDados(e) {
                var cursor = e.target.result;
                if (cursor) {
                    console.log(cursor.value.ssn);
                    console.log(cursor.value.nome);
                    console.log(cursor.value.email);
                    console.log(cursor.value.idade);
                    cursor.continue();
                }
            }
            ;


        </script>
    </head>
    <body >
        <?php
        // put your code here
        ?>
        
        TESTE
    </body>
</html>
