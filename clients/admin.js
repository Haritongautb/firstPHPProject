const btn = document.getElementById("get-data");
const contentBody = document.querySelector(".content-body");
const methods = {
    "get": "GET"
}

btn.addEventListener("click", getUsersData.bind(this))

function getUsersData(event) {
    event.preventDefault();

    if (event && event.target) {
        request("/server/getUsersData.php", methods.get)
            .then(res => {
                console.log(res);
                res.map((item => {
                    contentBody.innerHTML += buildUsersCard(item);
                }))
            })
    }
}

async function request(url, method) {
    const res = await fetch(url, {
        method
    })

    return await res.json();
}

function buildUsersCard(data) {
    const {login, email, id, currency, currency_q} = data;
    return `
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">${id}</h5>
                    <h5 class="card-title">${login}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">currency - ${currency ? currency : "none"} ${currency_q ? currency_q : "none"}</h6>
                </div>
            </div>
            `
}
