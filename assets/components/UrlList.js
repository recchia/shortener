import React from 'react';

export default class UrlList extends React.Component {

    render() {
        return (
            <div className="container">
                <h3 className="p-3 text-center">{this.props.title}</h3>
                <table className="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Long url</th>
                        <th>Short url</th>
                        <th>Likes</th>
                        <th>Hits</th>
                    </tr>
                    </thead>
                    <tbody>
                    {this.props.urls && this.props.urls.map(url =>
                        <tr key={url.id}>
                            <td>{url.longUrl}</td>
                            <td><a href={this.props.domain + url.shortUrl}>{url.shortUrl}</a></td>
                            <td>{url.likes}</td>
                            <td>{url.hits}</td>
                        </tr>
                    )}
                    </tbody>
                </table>
            </div>
        );
    }
}