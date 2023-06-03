    var ctx = document.getElementById('myChart').getContext('2d');
        let currenciesData = [];
        let currentExchangeValue = 0;
        let currentExchangeCurrency = "";
        const currency = document.querySelector(".currency");
        const pln = document.querySelector(".pln");
        const exchanged = document.getElementById("exchanged");
        const result = document.querySelector(".result");
        const selectBlock = document.getElementById("select-currency");
        selectBlock.innerHTML = "";
        getCurrencies();

        async function getJsonData() {
        }

        selectBlock.addEventListener("change", event => {
            const target = event.target;
            currenciesData.map(item => {
                if(item.name === target.value){
                    currentExchangeValue = item.var;
                    currentExchangeCurrency = item.name
                    changeCurrency(currentExchangeCurrency, currentExchangeValue);
                }
            })
        })  
        
        var data = {
            labels: document.getElementById("label-data"),
            datasets: [{
                label: 'Currencies',
                data: document.getElementById("data-2").value,
                backgroundColor: 'rgba(0, 123, 255, 0.5)', 
                borderColor: 'rgba(0, 123, 255, 1)', 
                borderWidth: 1 
            }]
        };

        var myChart = new Chart(ctx, {
            type: 'line', 
            data: data,
            options: {
                responsive: true, 
                scales: {
                y: {
                    beginAtZero: true 
                }
                }
            }
        });

        function getCurrencies() {
            request("http://logtest/server/getCurrentValues.php", "GET")
            .then(res => {
                currenciesData = res;
                currenciesData.map((item, index) => {
                    selectBlock.innerHTML += createOption(item, index);
                });
                currentExchangeValue = currenciesData[0]["var"];
                currentExchangeCurrency = currenciesData[0]["name"]
                changeCurrency(currentExchangeCurrency, currentExchangeValue);
            })
        }

        async function request(url, method) {
            const res = await fetch(url, {
                method
            })
            return await res.json();
        }

        function createOption(data, index){
            return `
                <option value=${data.name} id=${index}>${data.name}</option>
            `
        }

        function changeCurrency(curr, zl) {
            currency.innerHTML = `1 ${curr} = `;
            pln.innerHTML = `${zl} zł`;
        }

        exchanged.addEventListener("input", event => {
            const target = event.target;

            if(+target.value < 0){
                result.innerHTML = `0`;
                return;
            }
            if(target === "" || target == null){
                result.innerHTML = `0`;
                return;
            }
            result.innerHTML = `${target.value} zł = ${Math.floor(target.value / currentExchangeValue)} ${currentExchangeCurrency}`;
        })