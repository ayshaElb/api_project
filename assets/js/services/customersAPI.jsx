import axios from 'axios';

function findAll() {
    return axios
        .get("http://127.0.0.1:8001/api/customers")
        .then(response => response.data["hydra:member"]);
}

function deleteCustomer(id) {
    return axios
        .delete("http://127.0.0.1:8001/api/customers/" + id);
}

export default {
    findAll,
    delete: deleteCustomer
};