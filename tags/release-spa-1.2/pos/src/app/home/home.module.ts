import { FormsModule } from '@angular/forms';
import { SearchProductsModule } from '../search-products/search-products.module';
import { HomeRoutingModule } from './home-routing.module';
import { NgModule ,ModuleWithProviders} from '@angular/core';
import {CommonModule} from '@angular/common'
import { HomeService} from './home.service';
import {HomeComponent} from './home.component';
import { ModalModule } from 'ngx-bootstrap';

@NgModule({
    imports:[
      FormsModule,
      CommonModule,
      HomeRoutingModule,
      SearchProductsModule,
      ModalModule.forRoot()
      ],
    exports: [HomeComponent],
    declarations: [HomeComponent]
})
export class HomeModule {
    static forRoot(): ModuleWithProviders {
    return {
      ngModule: HomeModule,
      providers: [HomeService]
    }
  }
 }
