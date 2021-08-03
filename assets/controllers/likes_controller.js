
import { Controller } from 'stimulus';
import axios from "axios";

export default class extends Controller {
    static targets = ['count'];
    static values = {
        itemUrl: String
    }

    connect() {
    }

    increment() {
        axios.post(`${this.itemUrlValue}`, {
            headers: {
                'Accept': 'application/json',
            }
        }).then(response => {
            this.countTarget.innerText = response.data.likes;
        });
    }
}