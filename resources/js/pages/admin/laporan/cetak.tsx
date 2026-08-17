import { Head } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Printer } from 'lucide-react';

interface Props {
    data: Record<string, unknown>[];
    jenis: string;
    periode: string;
}

export default function LaporanCetak({ data, jenis, periode }: Props) {
    const titleMap: Record<string, string> = {
        konseling: 'Laporan Data Konseling',
        monitoring: 'Laporan Data Monitoring',
        pelanggaran: 'Laporan Data Pelanggaran',
        siswa: 'Laporan Data Siswa',
    };

    const handlePrint = () => {
        window.print();
    };

    return (
        <>
            <Head title={titleMap[jenis] || 'Laporan'} />
            <div className="min-h-screen bg-white p-8">
                <div className="mx-auto max-w-4xl">
                    <div className="mb-8 text-center">
                        <h1 className="text-2xl font-bold">SIBk - Sistem Informasi Bimbingan Konseling</h1>
                        <h2 className="text-xl font-semibold">SMKN 3 Padang</h2>
                        <p className="mt-2 text-muted-foreground">
                            {titleMap[jenis] || 'Laporan'} - Periode: {periode}
                        </p>
                    </div>

                    <div className="mb-4 print:hidden">
                        <Button onClick={handlePrint}>
                            <Printer className="mr-2 size-4" />
                            Cetak
                        </Button>
                    </div>

                    {data.length === 0 ? (
                        <p className="text-center text-muted-foreground">Tidak ada data untuk periode ini.</p>
                    ) : (
                        <table className="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr className="bg-gray-100">
                                    {Object.keys(data[0]).map((key) => (
                                        <th key={key} className="border border-gray-300 px-4 py-2 text-left text-sm font-medium">
                                            {key.replace(/_/g, ' ').replace(/\b\w/g, (l) => l.toUpperCase())}
                                        </th>
                                    ))}
                                </tr>
                            </thead>
                            <tbody>
                                {data.map((row, i) => (
                                    <tr key={i}>
                                        {Object.values(row).map((value, j) => (
                                            <td key={j} className="border border-gray-300 px-4 py-2 text-sm">
                                                {typeof value === 'object' ? JSON.stringify(value) : String(value)}
                                            </td>
                                        ))}
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    )}

                    <div className="mt-8 text-right text-sm text-muted-foreground print:block">
                        <p>Dicetak pada: {new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                    </div>
                </div>
            </div>
        </>
    );
}
