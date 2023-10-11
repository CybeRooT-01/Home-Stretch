import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AbsencesComponent } from './absences.component';

describe('AbsencesComponent', () => {
  let component: AbsencesComponent;
  let fixture: ComponentFixture<AbsencesComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AbsencesComponent]
    });
    fixture = TestBed.createComponent(AbsencesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
