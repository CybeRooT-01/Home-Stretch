import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DemandeANnulationComponent } from './demande-annulation.component';

describe('DemandeANnulationComponent', () => {
  let component: DemandeANnulationComponent;
  let fixture: ComponentFixture<DemandeANnulationComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [DemandeANnulationComponent]
    });
    fixture = TestBed.createComponent(DemandeANnulationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
