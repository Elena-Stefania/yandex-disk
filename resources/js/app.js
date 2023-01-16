import './bootstrap';

const updateNavOnclick = () => {
    $('.js-open-nav').click(async function () {
        const folder = this.getAttribute('data-folder');

        const result = await sendRequest({
            path: `/folder-list?folder=${folder}`,
            method: "GET",
        })

        if (result.status === 200) {
            this.nextElementSibling.innerHTML = result.html;
            updateNavOnclick();
        }
    })
}

$('.js-open-nav').click(async function () {
    const folder = this.getAttribute('data-folder');

    const result = await sendRequest({
        path: `/folder-list?folder=${folder}`,
        method: "GET",
    })

    if (result.status === 200) {
        this.nextElementSibling.innerHTML = result.html;
        updateNavOnclick();
    }
})

$('#uploadFile').click(() => {
    $('#fileInput').click();
})

$('#fileInput').change(async function () {
    const file = this.files[0];
    const folder = document.querySelector('#currentPath').value;

    const result = await sendRequest({
        path: `/upload-file`,
        method: "FILE",
        data: {file, folder}
    })

    if (result.status == 200)
        addElement(result.data);
    else
        showWarning(result.message);
});

const addElement = (elem) => {
    const item = document.createElement('div');
    item.setAttribute('data-file', elem.file);
    item.classList.add('file-item', 'js-get-file');
    item.innerHTML = `<img src="${getIcon(elem.name)}" alt=""><p>${elem.name}</p>`

    document.querySelector('.files').appendChild(item);
    $('.js-get-file').dblclick(async function () {
        const file = this.getAttribute('data-file');
        window.open(file);
    })
}

const showWarning = (message) => {
    const toast = document.querySelector('#toast-warning');
    toast.querySelector('.toast-text').innerText = message;
    toast.style.display = 'flex';
    setTimeout(() => toast.style.display = 'none', 2000)
}

const getIcon = (name) => {
    name = name.split('.').pop();

    switch(name) {
        case 'docx':
        case 'doc':
            return 'img/docx.png';
        case 'jpeg': return 'img/jpeg.png';
        case 'jpg': return 'img/jpg.png';
        case 'pdf': return 'img/pdf.png';
        case 'png': return 'img/png.png';
        case 'txt': return 'img/txt.png';
        case 'xls':
        case 'xlsx':
            return 'img/xls.png';
        case 'zip': return 'img/zip.png';
    }

    return 'img/unknown.png';
}

$('.js-open-dir').click(async function () {
    $('.js-open-dir').removeClass('active');
    this.classList.add('active');
})

$('.js-get-file').dblclick(async function () {
    const file = this.getAttribute('data-file');
    window.open(file);
})

$('.js-open-dir').dblclick(async function () {
    const file = this.getAttribute('data-link');
    window.open(file, "_self");
})

const sendRequest = async ({path, data = {}, method = "GET"}) => {
    try {
        if (method === "GET")
            return await fetch(path, {
                method,
                headers: {
                    url: "/payment",
                    "X-CSRF-Token": document
                        .querySelector("meta[name='csrf-token']")
                        .getAttribute("content"),
                },
            }).then((res) => res.json());

        if (method === "FILE") {
            const formData = new FormData();
            for (let [key, item] of Object.entries(data))
                formData.append(key, item);

            return await fetch(path, {
                method: "POST",
                headers: {
                    url: "/payment",
                    "X-CSRF-Token": document
                        .querySelector("meta[name='csrf-token']")
                        .getAttribute("content")
                },
                body: formData,
            }).then((res) => res.json());
        }

        return await fetch(path, {
            method,
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                url: "/payment",
                "X-CSRF-Token": document
                    .querySelector("meta[name='csrf-token']")
                    .getAttribute("content"),
            },
            body: JSON.stringify(data),
        }).then((res) => res.json());
    } catch (e) {
    }
};
