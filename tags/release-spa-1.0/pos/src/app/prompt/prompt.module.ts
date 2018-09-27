
import { NgModule } from '@angular/core';
import { PromptComponent } from './prompt.component';
import { ModalModule } from 'ngx-bootstrap';

@NgModule({
    imports: [ModalModule.forRoot()],
    exports: [PromptComponent],
    declarations: [PromptComponent]
})
export class PromptModule { }
