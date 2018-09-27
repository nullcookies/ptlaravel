import { FormControl } from '@angular/forms';
import { Observable } from 'rxjs/Rx';
import { HomeService } from './home.service';
import { SoldItems } from './sold-items';
import { Component, OnInit, ViewChild, ElementRef } from '@angular/core';
import { ModalDirective } from 'ngx-bootstrap/modal';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  host: { '(window:keyup)': 'hotkeys($event)' },
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  @ViewChild('qtyModal')
  public model: ModalDirective;

  @ViewChild('confirmModal')
  public cmodel: ModalDirective;

  @ViewChild('scanInput')
  public scanInput: ElementRef;

  @ViewChild('input')
  public Input: ElementRef;

  @ViewChild('cinput')
  public cInput: ElementRef;

  public updatedQuantity: number;
  public amount: number = 3400;
  public id: number;
  public imageId: number = 0;
  public collection: SoldItems[];
  public total: number = 0;
  public balance: number = 0;
  public item: SoldItems;


  constructor(private _prodService: HomeService) {
    this.collection = [];
  }

  hotkeys(event: KeyboardEvent) {
    if (event.keyCode == 113) {
      this.model.show();
    }
    if (event.keyCode == 115) {
      this.confirmModalShow();
    }
  }

  ngOnInit(): void { }

  public confirmOrder(): void {
    this.collection = [];
    this.imageId = 0;
    this.setScanInputFocus();
    this.cmodel.hide();
  }

  public updateQty() {
    console.log(this.updatedQuantity);
    if (this.updatedQuantity !== null) {
      this.increaseQty(this.updatedQuantity, this.collection.length - 1);
    }
    this.model.hide();
    this.setScanInputFocus();
  }

  public onShown(): void {
    this.updatedQuantity = 0;
    console.log('Quantity Addition Model is shown');
  }

  public setFocus(): void {
    this.Input.nativeElement.focus();
    this.cInput.nativeElement.focus();
  }
  
  public confirmModalShow(): void {
    this.total = this.calculateTotal();
    this.cmodel.show();
  }

  public conShown(): void {
    this.amount = 0;
    this.balance = - this.total;
    console.log('Confirm Model is shown');
  }

  public calcBal(event): void {
    this.balance = -this.total + this.amount;
    console.log(this.balance);
  }

  public add(): void {
    console.log(this.id);
    let item = this._prodService.getItem(this.id);
    if (item) {

      this.item = this.collection.filter(item => {
        return item.id == this.id
      })[0];

      if (this.item) {
        this.increaseQty(1, this.collection.indexOf(this.item));
        this.imageId = Number(this.id);
      } else {
        this.collection.push(item);
        this.imageId = Number(this.id);
      }
    } else {
      this.imageId = 0;
    }
    this.id = null;
  }

  remove(index: number): void {
    let quantity = this.collection[index].quantity;
    if (quantity > 1) {
      let quantity: number = --this.collection[index].quantity;
      let price: number = this.collection[index].price;
      this.collection[index].amount = quantity * price;
    } else {
      this.collection.splice(index, 1);
    }
  }

  private calculateTotal(): number {
    let total: number = 0;
    this.collection.forEach(element => {
      total += element.amount;
    });
    return total;
  }

  private setScanInputFocus() {
    this.scanInput.nativeElement.focus();
  }

  private increaseQty(qty: number, index: number): void {
    //  console.log("Increase Quantity Executed",qty,index);
    this.collection[index].quantity = this.collection[index].quantity + qty
    let quantity: number = this.collection[index].quantity;
    // console.log(quantity);
    let price: number = this.collection[index].price;
    this.collection[index].amount = quantity * price;
  }

  private decreaseQty(quantity: number): void {

  }
}
