import { AfficheUserComponent } from './components/affiche-user/affiche-user.component';
import { AuthenticationComponent } from './components/authentication/authentication.component';
import { FormLoginComponent } from './components/form-login/form-login.component';
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { FormRegisterComponent } from './components/form-register/form-register.component';




const routes: Routes = [
  {
  path: 'login',
  component: AuthenticationComponent
  },
  {
  path: 'register',    
  component: FormRegisterComponent,
  },
  {
    path:'lister',
    component: AfficheUserComponent
  }
  
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
