import { Headers } from '@angular/http';
import { Jsonp } from '@angular/http';
import { SoldItems } from '../home/sold-items';
import { Injectable } from '@angular/core';
import 'rxjs/add/operator/map';
@Injectable()
export class SearchProductsService {
    constructor(private jsonp:Jsonp) { }

    search(term: string) {
        var search = new URLSearchParams()
        var header = new Headers();

        header.append('Content-Type',"application/javascript")
        search.set('action', 'opensearch');
        search.set('search', term);
        search.set('format', 'json');
        return this.jsonp
            .get('http://en.wikipedia.org/w/api.php?callback=JSONP_CALLBACK', { search})
            .map((response) => response.json()[1]);
    }
}