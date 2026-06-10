@extends('layouts.app')

@section('title', 'Feedback Konseling - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Feedback Konseling Saya')
@section('breadcrumb', 'Siswa / Feedback Konseling')

@php
    $role = 'siswa';
    $userName = 'Ahmad Riyadi';
    $userRole = 'Siswa';
@endphp

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-comments"></i> Feedback Konseling</h3>
    </div>
    <div class="card-body">
        <div id="feedback-list" class="feedback-list">
            <div style="text-align: center; padding: 40px;">
                <p>Memuat feedback konseling...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let allFeedbacks = [];
    let siswaId = null;

    function getToken() {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Token autentikasi tidak ditemukan. Silakan login ulang.');
            return null;
        }
        return token;
    }

    async function getSiswaInfo() {
        const token = getToken();
        if (!token) return null;

        try {
            const response = await fetch('/api/me', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();
            if (result.success && result.data.profile) {
                siswaId = result.data.profile.id;
                return result.data.profile;
            }
        } catch (error) {
            console.error('Error getting siswa info:', error);
        }
        return null;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        if (Number.isNaN(date.getTime())) return dateString;
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    async function fetchFeedbackData() {
        if (!siswaId) return;

        const token = getToken();
        if (!token) return;

        try {
            const response = await fetch(`/api/siswa/feedback-saya/${siswaId}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil feedback');
            }

            const result = await response.json();
            allFeedbacks = result.data || [];
            renderFeedbackList(allFeedbacks);
        } catch (error) {
            console.error('Error fetching feedback:', error);
            document.getElementById('feedback-list').innerHTML = 
                '<div style="text-align: center; padding: 40px; color: red;">Gagal memuat feedback</div>';
        }
    }

    function renderFeedbackList(feedbacks) {
        const listDiv = document.getElementById('feedback-list');

        if (!feedbacks || feedbacks.length === 0) {
            listDiv.innerHTML = `
                <div style="text-align: center; padding: 60px 20px;">
                    <div style="font-size: 48px; margin-bottom: 16px;">📝</div>
                    <p style="font-size: 16px; color: #666;">
                        Belum ada feedback konseling dari guru BK
                    </p>
                    <p style="color: #999; margin-top: 8px;">
                        Feedback akan muncul setelah Anda menyelesaikan sesi konseling
                    </p>
                </div>
            `;
            return;
        }

        listDiv.innerHTML = feedbacks.map((f, idx) => {
            const konseling = f.penjadwalan || {};
            return `
                <div class="feedback-card">
                    <div class="feedback-header">
                        <div class="feedback-info">
                            <h4>${f.judul}</h4>
                            <small>
                                <i class="fas fa-calendar"></i> 
                                Konseling: ${formatDate(konseling.tanggal)}
                            </small>
                            <small style="margin-left: 16px;">
                                <i class="fas fa-user"></i> 
                                ${(f.bk || {}).nama || 'Guru BK'}
                            </small>
                        </div>
                    </div>
                    <div class="feedback-content">
                        ${f.isi}
                    </div>
                    <div class="feedback-footer">
                        <small>
                            <i class="fas fa-clock"></i> 
                            Diberikan: ${formatDate(f.created_at)}
                        </small>
                    </div>
                </div>
            `;
        }).join('');
    }

    document.addEventListener('DOMContentLoaded', async function() {
        const siswaInfo = await getSiswaInfo();
        if (!siswaInfo) {
            document.getElementById('feedback-list').innerHTML = 
                '<div style="text-align: center; padding: 40px; color: red;">Silakan login terlebih dahulu</div>';
            return;
        }
        fetchFeedbackData();
    });
</script>

<style>
    .feedback-list {
        display: grid;
        gap: 16px;
    }

    .feedback-card {
        border-left: 4px solid #667eea;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .feedback-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .feedback-header {
        margin-bottom: 16px;
    }

    .feedback-info h4 {
        margin: 0 0 8px 0;
        font-size: 16px;
        color: #333;
    }

    .feedback-info small {
        display: inline-block;
        color: #999;
        font-size: 12px;
        margin-right: 12px;
    }

    .feedback-info small i {
        margin-right: 4px;
    }

    .feedback-content {
        line-height: 1.8;
        color: #555;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #ddd;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .feedback-footer {
        color: #999;
        font-size: 12px;
    }

    .feedback-footer i {
        margin-right: 4px;
    }

    @media (max-width: 768px) {
        .feedback-card {
            padding: 16px;
        }

        .feedback-info small {
            display: block;
            margin-bottom: 4px;
            margin-right: 0;
        }
    }
</style>
@endpush
