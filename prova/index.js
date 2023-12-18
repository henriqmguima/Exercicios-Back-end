import createToast from './toast.js';

let jobs = [];
const select = document.querySelector('#jobs');
select.addEventListener('change', () => updateDetails());

const details = document.querySelector('#details');
function updateDetails() {
    const job = jobs.find(job => job.id == select.value);

    details.innerHTML = `
        <h3>${job.title}</h3>
        <p>Descrição: <b>${job.description}</b></p>
        <p>Salário: R$ <b>${parseFloat(job.salary).toFixed(2)}</b></p>
        <p>Empresa: <b>${job.company}</b></p>
    `;
}

async function updateJobs() {
    const data = await fetch('get-jobs.php').then(async res => res.json());
    console.log(data);

    if (data.status == "error") {
        createToast(data.message, data.status);
        return;
    }

    if (!jobs.length) {
        data.jobs.forEach(job => {
            const option = document.createElement('option');
            option.value = job.id;
            option.innerHTML = job.title;

            select.appendChild(option);
        });
    }
    jobs = data.jobs;
    updateDetails();
}

updateJobs();

const form = document.querySelector('form');
form.addEventListener('submit', async e => {
    e.preventDefault();

    const data = await fetch('apply.php', {
        method: 'POST',
        body: new FormData(form)
    }).then(res => res.json());
    console.log(data);

    createToast(data.message, data.status);

    if (data.status === 'success') {
        await updateJobs();
        updateDetails();
    }
});