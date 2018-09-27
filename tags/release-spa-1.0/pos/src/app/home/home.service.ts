import { Observable } from 'rxjs/Rx';
import { SoldItems } from './sold-items';
import { Injectable } from '@angular/core';

@Injectable()
export class HomeService {
    private products: SoldItems[];
    private onlineProducts: any[];

    constructor() {
        this.onlineProducts = [
            { id: 1, description: 'Fairness cream for face and skin', price: 34, quantity: 2, amount: 68 },
            { id: 2, description: 'Item two', price: 34, quantity: 2, amount: 68 },
            { id: 3, description: 'Fairness cream for face and skin', price: 34, quantity: 2, amount: 68 }
        ];
        this.products = [
            { id: 1, description: 'Fairness cream for face and skin', price: 100, quantity: 1, amount: 100 },
            { id: 2, description: 'Adidas Footbal', price: 150, quantity: 1, amount: 150 },
            { id: 3, description: 'Glaxy S8 Plus', price: 560, quantity: 1, amount: 560 },
            { id: 4, description: 'Glaxy A5 2017', price: 460, quantity: 1, amount: 460 },
            { id: 5, description: 'Glaxy A7 2017', price: 490, quantity: 1, amount: 490 }
        ];
    }

    public getItem(id: number): SoldItems {
        return this.products.filter(item => item.id == id)[0];
    }

    
}