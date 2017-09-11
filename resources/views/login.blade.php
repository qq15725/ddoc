<div style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #24292e;">
    <div style="width: 1012px; margin-right: auto; margin-left: auto;">
        <div style="width: 41.66667%; margin-right: auto; margin-left: auto;">
            <div style="padding: 24px 16px; color: #586069; background-color: #fafbfc; border-radius: 3px">
                <form action="" method="post">
                    <dl>
                        <dd style="margin-left: 0">
                            <input name="password" type="text" placeholder="Enter the password" style="width: 100%; min-height: 46px; padding: 10px;font-size: 16px;border-radius: 5px; max-width: 100%;margin-right: 5px;background-color: #fafbfc;line-height: 20px;color: #24292e;vertical-align: middle;background-repeat: no-repeat;background-position: right 8px center;border: 1px solid #d1d5da;outline: none;box-shadow: inset 0 1px 2px rgba(27,31,35,0.075);">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        </dd>
                    </dl>
                    <button type="submit" class="docute-button docute-button-success" style="width: 100%">查看文档</button>
                </form>
            </div>
        </div>
    </div>
</div>