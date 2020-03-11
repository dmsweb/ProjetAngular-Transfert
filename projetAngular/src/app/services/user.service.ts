import { User } from './../models/user';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(
    private http: HttpClient
  ) { }
  register(data : any)
  {
  	return this.http.post<any>(`${environment.apiUrl}/api/users`, data);
  }
  getAll()
  {
  	return this.http.get(`${environment.apiUrl}/api/users`);
  }
  getStatus(id: number)
  {
    return this.http.get(`${environment.apiUrl}/api/users/status/${id}`);
  }
}
