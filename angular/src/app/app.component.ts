import {Component, OnInit} from '@angular/core';
import { Http, URLSearchParams } from '@angular/http';

import { Admin } from './admin';
import { LoginService} from "./login.service";
import {createErrorResponse} from "angular-in-memory-web-api";

@Component({
    selector: "my-app",
    template: `
        <form>
            <label for="name">名前：</label>
            <input id="name" name="name" type="text" [(ngModel)]="name" />
            <input type="button" (click)="onclick()" value="送信" />
        </form>
        <div>{{result}}</div>
        <!--<form #myForm="ngForm" (ngSubmit)="show()" novalidate>-->
            <!--&lt;!&ndash;<table class="table">&ndash;&gt;-->
                <!--&lt;!&ndash;<tr>&ndash;&gt;-->
                    <!--&lt;!&ndash;<th>管理者ID（メールアドレス）</th>&ndash;&gt;-->
                <!--&lt;!&ndash;</tr>&ndash;&gt;-->
                <!--&lt;!&ndash;<tr *ngFor="let adm of admin">&ndash;&gt;-->
                    <!--&lt;!&ndash;<td>{{adm.admId}}</td>&ndash;&gt;-->
                <!--&lt;!&ndash;</tr>&ndash;&gt;-->
            <!--&lt;!&ndash;</table>&ndash;&gt;-->
            <!--<div>-->
                <!--<label for="admId">管理者ID（メールアドレス）</label><br />-->
                <!--<input id="admId" name="admId" type="email"-->
                       <!--[(ngModel)]="admin.admId" #admin="ngModel" required email />-->
                <!--<span *ngIf="admin.errors?.required">管理者ID（メールアドレス）は必須です。</span>-->

                <!--&lt;!&ndash;hasErrorメソッドの場合&ndash;&gt;-->
                <!--&lt;!&ndash;<span *ngIf="mail.hasError('required')">メールアドレスは必須です。</span>&ndash;&gt;-->

                <!--<span *ngIf="admin.errors?.email">メールアドレスを正しい形式で入力してください。</span>-->
            <!--</div>-->
            <!--&lt;!&ndash;<div>&ndash;&gt;-->
                <!--&lt;!&ndash;<label for="passwd">パスワード：</label><br />&ndash;&gt;-->
                <!--&lt;!&ndash;<input id="passwd" name="passwd" type="password"&ndash;&gt;-->
                       <!--&lt;!&ndash;[(ngModel)]="user.passwd"&ndash;&gt;-->
                       <!--&lt;!&ndash;required minlength="6" #passwd="ngModel" />&ndash;&gt;-->
                <!--&lt;!&ndash;&lt;!&ndash;<span *ngIf="passwd.errors?.required">&ndash;&gt;-->
                  <!--&lt;!&ndash;パスワードは必須です。</span>&ndash;&gt;&ndash;&gt;-->
                <!--&lt;!&ndash;<span *ngIf="passwd.errors?.required&& passwd.dirty">&ndash;&gt;-->
        <!--&lt;!&ndash;パスワードは必須です。</span>&ndash;&gt;-->
                <!--&lt;!&ndash;<span *ngIf="passwd.errors?.minlength">&ndash;&gt;-->
        <!--&lt;!&ndash;パスワードは6文字以上で入力してください。</span>&ndash;&gt;-->
            <!--&lt;!&ndash;</div>&ndash;&gt;-->
            <!--<div>-->
                <!--<input type="submit" value="送信"-->
                       <!--[disabled]="myForm.invalid" />-->

                <!--&lt;!&ndash;サブミット済みかどうかを判定&ndash;&gt;-->
                <!--&lt;!&ndash;<input type="submit" value="送信" -->
                  <!--[disabled]="myForm.invalid|| myForm.submitted" />&ndash;&gt;-->

                <!--&lt;!&ndash;pristine／dirtyプロパティを利用したリセットボタン&ndash;&gt;-->
                <!--&lt;!&ndash;<input type="reset" value="リセット" [disabled]="myForm.pristine" />&ndash;&gt;-->
                <!--&lt;!&ndash;<input type="reset" value="リセット" [disabled]="!myForm.dirty" />&ndash;&gt;-->
            <!--</div>-->
        <!--</form>-->
        <!-- <pre>{{myForm.value | json}}</pre> -->


    `
})
export class AppComponent implements OnInit{

    // admin : Admin;
    //
    // // LoginServiceをインスタンス化
    // constructor(private loginService: LoginService) {}

    name = '';
    result = '';

    // Httpサービスを注入
    constructor(private http: Http) { }

    onclick(){
        this.http.get('app/http.php', {
            params: { name: this.name }
        }).subscribe(
            // 通信成功時の処理（成功コールバック）
            response => {
                this.result = response.text();
            },
            // 通信失敗時の処理（失敗コールバック）
            error => {
                this.result = `通信失敗：${error.statusText}`;
            }
        );
    }

    ngOnInit(){
        // this.admin = this.loginService.getAdmin();
    }
    //
    // show() {
    //     console.log('管理者ID（メールアドレス）：' + this.admin.admId);
    //     console.log('パスワード：' + this.admin.admPass);
    // }
}