import { Controller } from 'stimulus';
import axios from 'axios';
import ReactDOM from 'react-dom';
import React from 'react';
import UrlList from '../components/UrlList';

export default class extends Controller {

    static values = {
        itemsUrl: String,
        title: String,
        baseUrl: String
    };

    connect() {
        async function getItems(url) {
            let response = await axios.get(`${url}?page=1&itemsPerPage=10&order%5Blikes%5D=desc`, {
                headers: {
                    'Accept': 'application/json',
                }
            });

            return response.data;
        };

        getItems(this.itemsUrlValue).then(response => {
            ReactDOM.render(
                <UrlList urls={response} title={this.titleValue} domain={this.baseUrlValue} />,
                this.element
            )
        });
    }
}