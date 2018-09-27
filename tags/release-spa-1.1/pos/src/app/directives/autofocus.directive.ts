import { ElementRef,Directive, Renderer, Input } from '@angular/core';

@Directive({
  selector: '[appAutofocus]'
})
export class AutofocusDirective {

  constructor(private el: ElementRef,private render : Renderer) {
  }
  ngAfterViewInit() {
    this.el.nativeElement.focus();
  }
}
