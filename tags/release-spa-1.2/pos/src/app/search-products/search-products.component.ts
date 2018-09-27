import { FormControl} from '@angular/forms';
import { Observable } from 'rxjs/Rx';
import { SearchProductsService } from './search-products.service';
import { Component, OnInit } from '@angular/core';
import 'rxjs/add/operator/debounceTime';
import 'rxjs/add/operator/distinctUntilChanged';
import 'rxjs/add/operator/switchMap';

@Component({
  selector: 'app-search-products',
  templateUrl: './search-products.component.html',
  styleUrls: ['./search-products.component.css']
})
export class SearchProductsComponent implements OnInit {
  items: Observable<Array<string>>;
  term = new FormControl();
  
  constructor(private _searchService: SearchProductsService) {

  }

  ngOnInit() {
    this.items = this.term.valueChanges
    .debounceTime(400)
    .distinctUntilChanged()
    .switchMap(term => this._searchService.search(term));
  }

}
