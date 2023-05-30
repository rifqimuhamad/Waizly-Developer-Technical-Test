import React, { useState, useEffect } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import "./Home.css";
import NavbarLogin from "./NavbarLogin";
import Hamburger from "./Hamburger";
import Footers from "./Footers";

axios.defaults.headers.common["Authorization"] = `Bearer ${localStorage.getItem("token")}`;

const Home = () => {
  const [pegawai, setPegawai] = useState([]);
  const [isUpdating, setIsUpdating] = useState(false);
  const [updatedData, setUpdatedData] = useState({});
  const [isLoading, setIsLoading] = useState(true);
  const [showMenu, setShowMenu] = useState(false);
  const toggleMenu = () => {
    setShowMenu(!showMenu);
  };

  const token = localStorage.getItem("token");
  const navigate = useNavigate();

  useEffect(() => {
    if (!token) {
      navigate("/login"); 
    }
  }, []);

  async function fetchData() {
    try {
      const response = await axios.get("http://127.0.0.1:8000/api/pegawai", {
        headers: {
          'Authorization': `Bearer ${token}` 
        }
      });

      setPegawai(response.data.data);
    } catch (error) {
      console.error(error);
    } finally {
      setIsLoading(false);
    }
  }

  async function addPegawai(pegawaiData) {
    try {
      const isEmailExist = pegawai.some(p => p.email === pegawaiData.email)

      if(isEmailExist){
        alert('Email sudah terdaftar! Silakan gunakan email yang lain.')
        return
      }

      const response = await axios.post("http://127.0.0.1:8000/api/pegawai", pegawaiData, {
        headers: {
          'Authorization': `Bearer ${token}` 
        }
      });

      const newPegawai = response.data.data;
      setPegawai([...pegawai, newPegawai]);
      setIsUpdating(false);
      setUpdatedData({});
    } catch (error) {
      console.error(error);
    }
  }
  
  async function updatePegawai(id, pegawaiData) {
    try {
      const isEmailExist = pegawai.some(p => p.email === pegawaiData.email)


      await axios.put(`http://127.0.0.1:8000/${id}`, pegawaiData, {
        headers: {
          'Authorization': `Bearer ${token}` 
        }
      });

      const updatedPegawai = pegawai.map((data) => {
        if (data.id === id) {
          return {
            ...data,
            ...pegawaiData,
          };
        }
        return data;
      });

      setPegawai(updatedPegawai);
      setIsUpdating(false);
      setUpdatedData({});
    } catch (error) {
      console.error(error);
    }
  }

  async function deletePegawai(id) {
    try {
      await axios.delete(`http://127.0.0.1:8000/${id}`, {
        headers: {
          'Authorization': `Bearer ${token}` 
        }
      });

      const newPegawai = pegawai.filter((data) => data.id !== id);
      setPegawai(newPegawai);
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    fetchData();
  }, []);

  if (isLoading) {
    return (
      <div>Loading...</div>
    );
  }

  return (
    <>
      <NavbarLogin />
      <Hamburger onClick={toggleMenu} />
      {!isUpdating && (
        <div className="container">
          <h3>Tabel Data Pegawai</h3>
          <button
            className="btn btn-sm btn-success mb-2"
            onClick={()=>{
              setIsUpdating(true)
            }}
          >
            Tambah Pegawai
          </button>
          <table className="table table-bordered mt-3">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>No. Telp</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              {pegawai.map((data, index) => (
                <tr key={index}>
                  <td>{index + 1}</td>
                  <td>{data.nama}</td>
                  <td>{data.email}</td>
                  <td>{data.alamat}</td>
                  <td>{data.notlpn}</td>
                  <td>
                    <div className="d-flex">
                      <button
                        className="btn btn-sm btn-primary mr-2"
                        onClick={()=>{
                          setIsUpdating(true);
                          setUpdatedData(data);
                        }}
                      >
                        Edit
                      </button>
                      <button
                        className="btn btn-sm btn-danger"
                        onClick={() => {
                          if (window.confirm('Apakah kamu yakin ingin menghapus?')) {
                            deletePegawai(data.id)
                          }
                        }}
                      >
                        Hapus
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {isUpdating && (
        <div className="container">
          <h3>{updatedData.id ? 'Update Data Pegawai' : 'Tambah Data Pegawai'}</h3>
          <form className="mt-3 mr-3 ml-3" onSubmit={(e) => {
            e.preventDefault();
            if(updatedData.id){
              updatePegawai(updatedData.id, updatedData);
            }else{
              addPegawai(updatedData);
            }
          }}>
            <div className="form-group">
              <label htmlFor="nama">Nama:</label>
              <input
                type="text"
                id="nama"
                name="nama"
                className="form-control"
                value={updatedData.nama || ""}
                onChange={(e) =>
                  setUpdatedData({ ...updatedData, nama: e.target.value })
                }
              />
            </div>
            <div className="form-group">
              <label htmlFor="email">Email:</label>
              <input
                type="email"
                id="email"
                name="email"
                className="form-control"
                value={updatedData.email || ""}
                onChange={(e) =>
                  setUpdatedData({ ...updatedData, email: e.target.value })
                }
              />
            </div>
            <div className="form-group">
              <label htmlFor="alamat">Alamat:</label>
              <textarea
                id="alamat"
                name="alamat"
                className="form-control"
                rows="4"
                value={updatedData.alamat || ""}
                onChange={(e) =>
                  setUpdatedData({ ...updatedData, alamat: e.target.value })
                }
              ></textarea>
            </div>
            <div className="form-group">
              <label htmlFor="notlpn">No. Telp:</label>
              <input
                type="text"
                id="notlpn"
                name="notlpn"
                className="form-control"
                value={updatedData.notlpn || ""}
                onChange={(e) =>
                  setUpdatedData({ ...updatedData, notlpn: e.target.value })
                }
              />
            </div>
            <button className="btn btn-success mt-4" disabled={!updatedData.nama || !updatedData.email || !updatedData.alamat || !updatedData.notlpn}>
              {updatedData.id ? 'Update' : 'Tambah'}
            </button>
            &nbsp;
            <button
              className="btn btn-danger mt-4"
              onClick={() => {
                setIsUpdating(false);
                setUpdatedData({});
              }}
            >
              Batal
            </button>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
          </form>
        </div>
      )}
      <Footers />
    </>
  );
};

export default Home;
