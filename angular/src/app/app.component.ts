import {Component, OnInit} from '@angular/core';

import { Admin } from './admin';
import { LoginService} from "./login.service";

@Component({
    selector: "my-app",
    template: `
        <form #myForm="ngForm" (ngSubmit)="show()" novalidate>
            <table class="table">
                <tr>
                    <th>管理者ID（メールアドレス）</th>
                </tr>
                <tr *ngFor="let adm of admin">
                    <td>{{adm.admId}}</td>
                </tr>
            </table>
            <!--<div>-->
                <!--<label for="admId">メールアドレス：</label><br />-->
                <!--<input id="admId" name="admId" type="email"-->
                       <!--[(ngModel)]="admin.admId" #admin="ngModel" required email />-->
                <!--<span *ngIf="admin.errors?.required">メールアドレスは必須です。</span>-->

                <!--&lt;!&ndash;hasErrorメソッドの場合&ndash;&gt;-->
                <!--&lt;!&ndash;<span *ngIf="mail.hasError('required')">メールアドレスは必須です。</span>&ndash;&gt;-->

                <!--<span *ngIf="admin.errors?.email">-->
        <!--メールアドレスを正しい形式で入力してください。</span>-->
            <!--</div>-->
            <!--<div>-->
                <!--<label for="passwd">パスワード：</label><br />-->
                <!--<input id="passwd" name="passwd" type="password"-->
                       <!--[(ngModel)]="user.passwd"-->
                       <!--required minlength="6" #passwd="ngModel" />-->
                <!--&lt;!&ndash;<span *ngIf="passwd.errors?.required">-->
                  <!--パスワードは必須です。</span>&ndash;&gt;-->
                <!--<span *ngIf="passwd.errors?.required&& passwd.dirty">-->
        <!--パスワードは必須です。</span>-->
                <!--<span *ngIf="passwd.errors?.minlength">-->
        <!--パスワードは6文字以上で入力してください。</span>-->
            <!--</div>-->
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
        </form>
        <!-- <pre>{{myForm.value | json}}</pre> -->


    `
})
export class AppComponent implements OnInit{
    // admin = {
    //     admId: 'hoge@example.com',
    //     admPass: '',
    // };

    admin : Admin[];

    // LoginServiceをインスタンス化
    constructor(private loginService: LoginService) {}

    ngOnInit(){
        this.admin = this.loginService.getAdmin();
    }

    // show() {
    //     console.log('メールアドレス：' + this.user.mail);
    //     console.log('パスワード：' + this.user.passwd);
    // }
}