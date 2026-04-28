@extends('admin.layouts.app')

@section('title', 'Settings')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item active">Settings</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="page-header">
    <h1>Settings</h1>
    <p>Manage system configuration and preferences.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- GENERAL SETTINGS -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">General Settings</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Site Name</label>
                        <input type="text" class="form-control" value="CineMax Cinema Booking">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Site Description</label>
                        <textarea class="form-control" rows="3">Your premier cinema booking platform for the best movie experiences</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Support Email</label>
                                <input type="email" class="form-control" value="support@cinemax.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Support Phone</label>
                                <input type="tel" class="form-control" value="+63 123 456 7890">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- PAYMENT SETTINGS -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Payment Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="checkCC" checked>
                        <label class="form-check-label" for="checkCC">
                            Enable Credit Card Payments
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="checkWallet" checked>
                        <label class="form-check-label" for="checkWallet">
                            Enable E-Wallet Payments
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="checkBank" checked>
                        <label class="form-check-label" for="checkBank">
                            Enable Bank Transfer
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>

        <!-- EMAIL SETTINGS -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Email Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Mail Driver</label>
                    <select class="form-select">
                        <option selected>SMTP</option>
                        <option>Sendmail</option>
                        <option>Mailgun</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">SMTP Host</label>
                    <input type="text" class="form-control" value="smtp.mailtrap.io">
                </div>

                <div class="mb-3">
                    <label class="form-label">SMTP Port</label>
                    <input type="number" class="form-control" value="2525">
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- SYSTEM INFO -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">System Information</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                    <span class="text-muted">Laravel Version</span>
                    <span class="fw-bold">11.0.0</span>
                </div>
                <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                    <span class="text-muted">PHP Version</span>
                    <span class="fw-bold">8.2.4</span>
                </div>
                <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                    <span class="text-muted">Database</span>
                    <span class="fw-bold">MySQL 8.0.0</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">App Version</span>
                    <span class="fw-bold">1.0.0</span>
                </div>
            </div>
        </div>

        <!-- MAINTENANCE MODE -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Maintenance Mode</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="checkMaintenance">
                        <label class="form-check-label" for="checkMaintenance">
                            Enable Maintenance Mode
                        </label>
                    </div>
                    <div class="form-text">Site will be temporarily unavailable for users</div>
                </div>
                <button type="submit" class="btn btn-secondary w-100">Update Status</button>
            </div>
        </div>

        <!-- DANGER ZONE -->
        <div class="card border-danger" style="border-color:rgba(220,53,69,0.35) !important;">
            <div class="card-header" style="background:rgba(220,53,69,0.12) !important;">
                <h5 class="mb-0" style="color:#f87171;">Danger Zone</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-danger" onclick="clearCache()">
                        <i class="bi bi-trash"></i> Clear Cache
                    </button>
                    <button class="btn btn-outline-danger" onclick="resetDatabase()">
                        <i class="bi bi-exclamation-triangle"></i> Reset Database
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function clearCache() {
        if (confirm('Are you sure you want to clear all cached data?')) {
            alert('Cache cleared successfully');
        }
    }

    function resetDatabase() {
        if (confirm('WARNING: This will permanently delete all data and cannot be undone! Are you sure?')) {
            alert('Database reset initiated');
        }
    }
</script>
@endsection
