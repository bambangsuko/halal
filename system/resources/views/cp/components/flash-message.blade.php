@if (session('success'))

    <div class="alert alert-light alert-dismissible show fade" style="border-left: 4px solid #00a65a;box-shadow: 0 1px 1px rgba(0,0,0,0.1); background-color: #fff;">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
              <span>×</span>
            </button>
            {{ session('success') }}
        </div>
    </div>

@endif

@if (session('error'))

    <div class="alert alert-light alert-dismissible show fade" style="border-left: 4px solid #fc544b;box-shadow: 0 1px 1px rgba(0,0,0,0.1); background-color: #fff;">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
              <span>×</span>
            </button>
            {{ session('error') }}
        </div>
    </div>

@endif