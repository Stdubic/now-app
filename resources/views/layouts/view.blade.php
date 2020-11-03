<div class="m-portlet__head">
    <div class="m-portlet__head-wrapper">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="{{ $icon }}"></i>
				</span>
                <h3 class="m-portlet__head-text m--font-primary">
                    {{ strtoupper($title) }}
                    <?php

                    if(isset($created_at) && !empty($created_at))
                    {
                    ?>
                    <small title="Last updated">
                        <i class="fa fa-clock"></i> {{ formatLocalTimestamp($created_at) }}
                    </small>
                    <?php
                    }

                    ?>
                </h3>
            </div>
        </div>
    </div>
</div>