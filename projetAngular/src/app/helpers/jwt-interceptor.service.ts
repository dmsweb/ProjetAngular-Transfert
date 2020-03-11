import { AuthenticationService } from './../services/authentication.service';
import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent} from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({                               
  providedIn: 'root'
})
export class JwtInterceptorService implements  HttpInterceptor  {

  constructor(private authenticationService: AuthenticationService)
  {

  }
  intercept (req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>>
  {
     let currentuser = this.authenticationService.currentUserValue;  
     if(currentuser && currentuser.token)
     {
      req = req.clone({
        setHeaders: {Authorization: `Bearer ${currentuser.token}`}
    });
     }
     return next.handle(req);
  } 
  
}
