import { JsonpModule } from '@angular/http';
import { ReactiveFormsModule } from '@angular/forms';
import { SearchProductsService } from './search-products.service';

import { NgModule ,ModuleWithProviders} from '@angular/core';
import { CommonModule } from '@angular/common'
import { SearchProductsComponent } from "app/search-products/search-products.component";

@NgModule({
    imports: [CommonModule,ReactiveFormsModule,JsonpModule],
    exports: [SearchProductsComponent],
    declarations: [SearchProductsComponent],providers: [SearchProductsService]
})
export class SearchProductsModule {
    static forRoot(): ModuleWithProviders {
    return {
      ngModule: SearchProductsModule,
      providers: [SearchProductsService]
    }
  }
 }
