import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { AuthModule } from './auth/auth.module';
import { HTTP_INTERCEPTORS, HttpClientModule } from '@angular/common/http';
import { DashboardModule } from './dashboard/dashboard.module';
import { SweetAlert2Module } from '@sweetalert2/ngx-sweetalert2';
import { NotFoundComponent } from './not-found/not-found.component';
import { TokenInterceptor } from './shared/Token.interceptor';
@NgModule({
  declarations: [AppComponent, NotFoundComponent],
  imports: [
    BrowserModule,
    AppRoutingModule,
    AuthModule,
    HttpClientModule,
    DashboardModule,
    SweetAlert2Module.forRoot(),
  ],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: TokenInterceptor,
      multi: true,
    },
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}
