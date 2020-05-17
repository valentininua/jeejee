<div class="container">

    <?php
    if (isset($arr['error'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $arr['error']; ?>
        </div>
        <?php
    }

    if (isset($arr['info'])) { ?>
        <div class="alert alert-primary" role="alert">
            <?php echo $arr['info']; ?>
        </div>
        <?php
    }
    ?>
    <div class="row">
        <div class="col-md-offset-3 col-md-6">

            <div class="tab" role="tabpanel">

                <div class="tab-content tabs">
                    <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                        <div style="color: #f00" id="valid"></div>
                        <form class="form-horizontal"  action="/Auth/login/" method="post">
                            <div class="form-group">
                                <label for="accountFirstName">Name</label>
                                <input type="text" name='FirstName'
                                       class="form-control"
                                >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name='accountPassword'   class="form-control" id="accountPassword">
                            </div>
                            <div class="form-group">
                                  <button type="submit" name="submit" value="submitLogin" class="btn btn-default buttonClass">Sign ins</button>
                            </div>
                            <div class="form-group forgot-pass">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div><!-- /.col-md-offset-3 col-md-6 -->
    </div><!-- /.row -->
</div><!-- /.container -->
